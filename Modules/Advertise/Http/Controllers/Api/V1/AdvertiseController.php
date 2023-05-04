<?php

namespace Modules\Advertise\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Modules\Advertise\Interfaces\Api\V1\AdvertiseRepositoryInterface;
use Modules\Advertise\Transformers\Api\V1\AdvertiseResource;

class AdvertiseController extends Controller
{
    public AdvertiseRepositoryInterface $repository;

    public function __construct(AdvertiseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($type): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return AdvertiseResource::collection($this->repository->index($type));
    }

    public function one($type): AdvertiseResource
    {
        return AdvertiseResource::make($this->repository->one($type));
    }
}
