<?php

namespace Modules\Product\Repositories;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Currency\Repositories\Web\CurrencyRepository;
use Modules\Product\Entities\Product;

class ProductBaseRepository extends DBTransactionRepository
{
    use BaseRepositoryTrait;

    public Product|null $model;
    public int|float $currency = 1;
    public string $order;

    public array $select = [
        'id', 'title', 'thumbnail', 'price', 'discount', 'category_id', 'city_id', 'rank'
    ];

    public function __construct(Product $model = new Product())
    {
        $this->model = $model;
        $this->order = 'CASE WHEN rank > 0 THEN 1 ELSE 0 END DESC, rank ASC';
    }

    public function mainShow($id): void
    {
        $this->getCurrency();
        $this->model = $this->model->with(['category.parent', 'details'])->available()->findOrFail($id);
    }

    public function getCurrency(): void
    {
        $this->currency = ( new CurrencyRepository() )->value();
    }

    public function getPaginatedProducts($query, $select, $limit = null)
    {
        $q = $query->orderByRaw($this->order);
        return is_null($limit) ? $q->simplePaginate(5, $select) : $q->limit($limit)->get($select);
    }
}
