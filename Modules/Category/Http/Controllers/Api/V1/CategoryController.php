<?php

namespace Modules\Category\Http\Controllers\Api\V1;

use Modules\Category\Http\Requests\Api\V1\CategoryRequest;
use Illuminate\Routing\Controller;
use Modules\Category\Interfaces\Api\V1\CategoryRepositoryInterface;
use Modules\Category\Transformers\Api\V1\CategoryResource;

class CategoryController extends Controller
{
    public CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(CategoryRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(CategoryRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
