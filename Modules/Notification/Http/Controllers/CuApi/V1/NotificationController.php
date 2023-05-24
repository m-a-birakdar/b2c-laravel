<?php

namespace Modules\Notification\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Notification\Interfaces\CuApi\V1\NotificationRepositoryInterface;
use Modules\Notification\Transformers\CuApi\V1\NotificationResource;

class NotificationController extends Controller
{
    public NotificationRepositoryInterface $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($type = null): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return NotificationResource::collection($this->repository->index($type));
    }

    public function read($id = null): MainResource
    {
        return MainResource::make(null, $this->repository->read($id));
    }
}
