<?php

namespace Modules\Notification\Http\Controllers\Api\V1;

use Modules\Notification\Http\Requests\Api\V1\NotificationRequest;
use Illuminate\Routing\Controller;
use Modules\Notification\Interfaces\Api\V1\NotificationRepositoryInterface;
use Modules\Notification\Transformers\Api\V1\NotificationResource;

class NotificationController extends Controller
{
    public NotificationRepositoryInterface $repository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(NotificationRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(NotificationRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
