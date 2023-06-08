<?php

namespace Modules\Report\Repositories\DaApi;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Report\Entities\Report;
use Modules\Report\Interfaces\DaApi\MainReportRepositoryInterface;

class MainReportRepository implements MainReportRepositoryInterface
{
    use BaseRepositoryTrait;

    public Report|null $model;

    public function __construct(Report $model = new Report())
    {
        $this->model = $model;
    }

    public function show($type, $where): \Jenssegers\Mongodb\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|null
    {
        return $this->main($type)->where(function ($q) use ($where){
            foreach ($where as $key => $item)
                $q->where($key, $item);
        })->first();
    }

    public function index($type, $sub): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->main($type)->orderBy('created_at')->limit($sub)->get();
    }

    private function main($type): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->where('type', $type);
    }
}
