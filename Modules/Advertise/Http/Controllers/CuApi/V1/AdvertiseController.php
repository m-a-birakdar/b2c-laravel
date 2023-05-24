<?php

namespace Modules\Advertise\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Advertise\Interfaces\CuApi\V1\AdvertiseRepositoryInterface;
use Modules\Advertise\Transformers\CuApi\V1\AdvertiseResource;

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

    public function click($id): MainResource
    {
        return MainResource::make(null, $this->repository->click($id));
    }
}
