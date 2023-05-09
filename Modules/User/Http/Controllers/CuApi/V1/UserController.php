<?php

namespace Modules\User\Http\Controllers\CuApi\V1;

use Modules\User\Http\Requests\CuApi\V1\UserRequest;
use Illuminate\Routing\Controller;
use Modules\User\Interfaces\CuApi\V1\UserRepositoryInterface;
use Modules\User\Transformers\CuApi\V1\UserResource;

class UserController extends Controller
{
    public UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(UserRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(UserRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
