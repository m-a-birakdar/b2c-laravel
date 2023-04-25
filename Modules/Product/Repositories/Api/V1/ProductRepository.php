<?php

namespace Modules\Product\Repositories\Api\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Product\Interfaces\Api\V1\ProductRepositoryInterface;
use Modules\Product\Entities\Product;

class ProductRepository implements ProductRepositoryInterface
{
    use BaseRepositoryTrait;

    public Product|null $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index($categoryId, $columns = ['*'])
    {
        return $this->model->where('category_id', $categoryId)->simplePaginate();
    }

    public function show($id, $with = null, $columns = ['*'])
    {
        return $this->model->with(is_null($with) ? [] : $with)->findOrFail($id, $columns);
    }
}
