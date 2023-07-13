<?php

namespace Modules\Order\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Order\Http\Requests\CuApi\V1\OrderRequest;
use Modules\Order\Http\Requests\CuApi\V1\OrderReviewRequest;
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

    public function save(OrderRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->save($request));
    }

    public function show($orderId): OrderShowResource
    {
        return OrderShowResource::make($this->repository->show($orderId));
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return OrderResource::collection($this->repository->index());
    }

    public function review(OrderReviewRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->review($request->validated()));
    }
}
