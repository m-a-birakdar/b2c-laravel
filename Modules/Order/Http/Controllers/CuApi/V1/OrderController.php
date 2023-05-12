<?php

namespace Modules\Order\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Order\Interfaces\CuApi\V1\OrderRepositoryInterface;
use Modules\Order\Transformers\CuApi\V1\OrderResource;
use Modules\Order\Transformers\CuApi\V1\OrderShowResource;

class OrderController extends Controller
{
    public OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(): MainResource
    {
        return MainResource::make(null, $this->repository->save());
    }

    public function show($orderId): OrderShowResource
    {
        return OrderShowResource::make($this->repository->show($orderId));
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return OrderResource::collection($this->repository->index());
    }
}
