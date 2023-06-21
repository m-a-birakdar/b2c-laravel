<?php

namespace Modules\Product\Repositories\AdApi\V1;

use Modules\Product\Entities\ProductDetails;
use Modules\Product\Interfaces\AdApi\V1\ProductRepositoryInterface;
use Modules\Product\Repositories\ProductBaseRepository;

class ProductRepository extends ProductBaseRepository implements ProductRepositoryInterface
{
    public function index($categoryId)
    {
        $query = $this->model->query()->where('category_id', $categoryId)->where('city_id', $this->getCityId());
        return $this->getPaginatedProducts($query, array_merge($this->select, ['status', 'sku']));
    }

    public function show($id): ?\Modules\Product\Entities\Product
    {
        $this->mainShow($id);
        $this->model->lira_price = $this->model->price * $this->currency;
        return $this->model;
    }

    public function search($text)
    {
        $query = $this->model->query()->where('title', 'Like', '%' . str_replace(' ', '%', $text) . '%')->where('city_id', $this->getCityId());
        return $this->getPaginatedProducts($query, array_merge($this->select, ['status', 'sku']));
    }

    public ProductDetails|null $productDetails;

    public function update($array, $id)
    {
        $this->find($id, null, ['id', 'status', 'price', 'discount']);
        $this->productDetails = ( new ProductDetailsRepository )->findWhere('product_id', $id, null, ['id', 'quantity']);
        return $this->executeInTransaction(function () use ($array) {
            $this->model->update($array);
            $this->productDetails->update([
                'quantity' => (int) $array['quantity']
            ]);
            return true;
        });
    }

    private function getCityId(): int
    {
        return 1;
    }
}
