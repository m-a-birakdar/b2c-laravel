<?php

namespace Modules\Product\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Currency\Repositories\Web\CurrencyRepository;
use Modules\Product\Interfaces\CuApi\V1\ProductRepositoryInterface;
use Modules\Product\Entities\Product;

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
        $currency = ( new CurrencyRepository() )->value();
        return $this->model->available()->where('category_id', $categoryId)->where('city_id', $cityId)
            ->orderByRaw('CASE WHEN rank > 0 THEN 1 ELSE 0 END DESC, rank ASC')->simplePaginate()->map(function ($product) use ($currency) {
                $product->price = $product->price * $currency;
                return $product;
            });
    }

    public function show($id, $with = null, $columns = ['*'])
    {
        $this->model = $this->model->with(is_null($with) ? [] : $with)->available()->findOrFail($id, $columns);
        $this->model->price = $this->model->price * ( new CurrencyRepository() )->value();
        return $this->model;
    }
}
