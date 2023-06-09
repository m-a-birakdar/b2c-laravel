<?php

namespace Modules\Product\Repositories\AdApi\V1;

use Modules\Product\Interfaces\AdApi\V1\ProductRepositoryInterface;
use Modules\Product\Repositories\ProductBaseRepository;

class ProductRepository extends ProductBaseRepository implements ProductRepositoryInterface
{
    public function index($categoryId)
    {
        $query = $this->model->where('category_id', $categoryId)->where('city_id', $this->getCityId());
        return $this->getPaginatedProducts($query, array_merge($this->select, ['status', 'sku']));
    }

    public function show($id)
    {
        $this->mainShow($id);
        $this->model->lira_price = $this->model->price * $this->currency;
        return $this->model;
    }

    public function search()
    {
        $query = $this->model->where('title', 'Like', '%' . request('text') . '%')->where('city_id', $this->getCityId());
        return $this->getPaginatedProducts($query, $this->select);
    }

    public function update($array, $id)
    {
        // TODO: Implement update() method.
    }

    private function getCityId(): int
    {
        return 1;
    }
}
