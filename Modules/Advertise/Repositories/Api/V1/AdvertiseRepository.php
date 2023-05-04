<?php

namespace Modules\Advertise\Repositories\Api\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Advertise\Interfaces\Api\V1\AdvertiseRepositoryInterface;
use Modules\Advertise\Entities\Advertise;

class AdvertiseRepository implements AdvertiseRepositoryInterface
{
    use BaseRepositoryTrait;

    public Advertise|null $model;

    public function __construct(Advertise $model = new Advertise())
    {
        $this->model = $model;
    }

    public function index($type)
    {
        return $this->model->where('type', $type)->orderBy('rank')->get();
    }

    public function one($type)
    {
        return $this->model->where('type', $type)->orderBy('rank')->first();
    }
}
