<?php

namespace Modules\Category\Http\Controllers\Api\V1;

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

    public function main(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CategoryResource::collection($this->repository->main());
    }

    public function sub($id)
    {
        return CategoryResource::collection($this->repository->sub($id));
    }
}
