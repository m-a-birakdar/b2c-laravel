<?php

namespace Modules\Product\Repositories\AdApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Currency\Repositories\Web\CurrencyRepository;
use Modules\Product\Entities\Product;
use Modules\Product\Interfaces\AdApi\V1\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    use BaseRepositoryTrait;

    public Product|null $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index($categoryId, $cityId, $columns = ['*'])
    {
        $currency = ( new CurrencyRepository )->value();
        return $this->model->where('category_id', $categoryId)->where('city_id', $cityId)->simplePaginate()->map(function ($product) use ($currency) {
            $product->lira_price = $product->price * $currency;
            return $product;
        });
    }

    public function show($id, $with = null, $columns = ['*'])
    {
        $this->model = $this->model->with(is_null($with) ? [] : $with)->findOrFail($id, $columns);
        $this->model->lira_price = $this->model->price * ( new CurrencyRepository )->value();
        return $this->model;
    }

    public function update($array, $id)
    {
        // TODO: Implement update() method.
    }
}
