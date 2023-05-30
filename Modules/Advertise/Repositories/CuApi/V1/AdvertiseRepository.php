<?php

namespace Modules\Advertise\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Advertise\Enums\StatisticsEnum;
use Modules\Advertise\Interfaces\CuApi\V1\AdvertiseRepositoryInterface;
use Modules\Advertise\Entities\Advertise;
use Modules\Advertise\Jobs\IncrementAdvertiseViewsJob;

class AdvertiseRepository implements AdvertiseRepositoryInterface
{
    use BaseRepositoryTrait;

    public Advertise|null $model;

    public function __construct(Advertise $model = new Advertise())
    {
        $this->model = $model;
    }

    public function index($type, $user)
    {
        return $this->model->available()->where('type', $type)->orderBy('rank')->get();
    }

    public function one($type, $user)
    {
        return $this->model->available()->where('type', $type)->orderBy('rank')->first();
    }

    public function statistics($type, $id, $user): bool
    {
        IncrementAdvertiseViewsJob::dispatch($id, $user, $type, time());
        return true;
    }

    public function click($id, $user): bool|int
    {
        return $this->statistics(StatisticsEnum::Click, $id, $user);
    }

    public function view($id, $user): bool|int
    {
        return $this->statistics(StatisticsEnum::View, $id, $user);
    }
}
