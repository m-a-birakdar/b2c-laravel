<?php

namespace Modules\Report\Repositories\DaApi;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Report\Entities\ProductReport;
use Modules\Report\Interfaces\DaApi\ProductReportRepositoryInterface;

class ProductReportRepository implements ProductReportRepositoryInterface
{
    use BaseRepositoryTrait;

    public ProductReport|null $model;

    public function __construct(ProductReport $model = new ProductReport())
    {
        $this->model = $model;
    }

    public function show($id, $type, $where)
    {
        return ProductReport::query()->where('id', (int) $id)->where('type', $type)->where(function ($q) use ($where){
            foreach ($where as $key => $item) {
                $q->where($key, $item);
            }
        })->first();
    }

    public function compare(array $ids, $type)
    {
        // TODO: Implement compare() method.
    }

    public function index($ids, $type, $where)
    {
        // TODO: Implement index() method.
    }
}
