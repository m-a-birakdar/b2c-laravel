<?php

namespace Modules\Product\Repositories\CuApi\V1;

use Modules\Product\Enums\StatisticsEnum;
use Modules\Product\Interfaces\CuApi\V1\ProductRepositoryInterface;
use Modules\Product\Jobs\ProductStatisticsJob;
use Modules\Product\Repositories\ProductBaseRepository;
use Modules\User\Jobs\Cu\SaveSearchValueJob;

class ProductRepository extends ProductBaseRepository implements ProductRepositoryInterface
{
    public function index($categoryId, $cityId)
    {
        $query = $this->model->available()->where('category_id', $categoryId)->where('city_id', $cityId);
        return $this->getPaginatedProducts($query, $this->select);
    }

    public function show($id, $userId): ?\Modules\Product\Entities\Product
    {
        $this->mainShow($id);
        $this->model->price = $this->model->price * $this->currency;
        ProductStatisticsJob::dispatch($id, $userId, StatisticsEnum::View, time());
        return $this->model;
    }

    public function getFavorites($productIds): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->model->available()->whereIntegerInRaw('id', $productIds)->simplePaginate();
    }

    public function search($cityId, $userId)
    {
        $text = str_replace(' ', '%', request('text'));
        $query = $this->model->available()->where('title', 'Like', '%' . request('text') . '%')->where('city_id', $cityId);
        SaveSearchValueJob::dispatch($userId, $text, time());
        return $this->getPaginatedProducts($query, $this->select);
    }

    public function related($categoryId, $cityId, $id)
    {
        $query = $this->model->available()->where('category_id', $categoryId)->where('city_id', $cityId)->where('id', '!=', $id);
        return $this->getPaginatedProducts($query, $this->select, 10);
    }
}
