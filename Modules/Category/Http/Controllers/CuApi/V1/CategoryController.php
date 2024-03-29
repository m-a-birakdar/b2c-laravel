<?php

namespace Modules\Category\Http\Controllers\CuApi\V1;

use App\Traits\ModelExistsTrait;
use Illuminate\Routing\Controller;
use Modules\Category\Interfaces\CuApi\V1\CategoryRepositoryInterface;
use Modules\Category\Transformers\CuApi\V1\CategoryResource;

class CategoryController extends Controller
{
    use ModelExistsTrait;

    public CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function main(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CategoryResource::collection($this->repository->main());
    }

    public function sub($id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->exists(['category' => $id]);
        return CategoryResource::collection($this->repository->sub($id));
    }
}
