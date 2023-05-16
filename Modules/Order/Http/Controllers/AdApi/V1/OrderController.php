<?php

namespace Modules\Order\Http\Controllers\AdApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Http\Requests\AdApi\V1\OrderToShipmentRequest;
use Modules\Order\Interfaces\AdApi\V1\OrderRepositoryInterface;
use Modules\Order\Transformers\AdApi\V1\OneOrderResource;
use Modules\Order\Transformers\AdApi\V1\OrderResource;

class OrderController extends Controller
{
    public OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($status): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->validateStatus($status);
        return OrderResource::collection($this->repository->index($status));
    }

    public function show($id): OneOrderResource
    {
        return OneOrderResource::make($this->repository->show($id));
    }

    public function toProcessing($id): MainResource
    {
        return MainResource::make(null, $this->repository->toProcessing($id));
    }

    public function toShipment(OrderToShipmentRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->toShipment($request->validated()));
    }

    public function validateStatus($status)
    {
        $enums = array_map('strtolower', array_column(OrderStatusEnum::cases(), 'name'));
        abort_if(! in_array($status, $enums), 404);
    }
}
