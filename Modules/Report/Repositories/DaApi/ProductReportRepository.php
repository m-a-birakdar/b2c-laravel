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

    public function show($id, $type, $where): \Jenssegers\Mongodb\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|null
    {
        return $this->main($id, $type)->where(function ($q) use ($where){
            foreach ($where as $key => $item)
                $q->where($key, $item);
        })->first(array_merge(array_keys($where), ['id', 'type', 'created_at', 'orders_count']));
    }

    public function compareOne(array $ids, $type, $where): array
    {
        $data = [];
        foreach ($ids as $id)
            $data[] = $this->show($id, $type, $where);
        return $data;
    }

    public function index($id, $type, $sub): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->main($id, $type)->orderBy('created_at')->limit($sub)->get(['id', 'type', 'created_at', 'orders_count']);
    }

    public function compareMany($ids, $type, $sub): \Illuminate\Database\Eloquent\Collection|array
    {
        $data = [];
        foreach ($ids as $id)
            $data[] = $this->index($id, $type, $sub);
        return $data;
    }

    private function main($id, $type): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->where('id', (int) $id)->where('type', $type);
    }
}
