<?php

namespace Modules\Advertise\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
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

    public function index($type)
    {
        $advertises = $this->model->where('type', $type)->orderBy('rank')->get();
        IncrementAdvertiseViewsJob::dispatch($advertises->pluck('id')->toArray());
        return $advertises;
    }

    public function one($type)
    {
        $advertise = $this->model->where('type', $type)->orderBy('rank')->first();
        IncrementAdvertiseViewsJob::dispatch([$advertise->id]);
        return $advertise;
    }

    public function increment($value, $id)
    {
        return $this->model->where('id', $id)->update([
            $value => $this->model->{$value}++
        ]);
    }

    public function click($id): bool|int
    {
        return $this->increment('clicks', $id);
    }
}
