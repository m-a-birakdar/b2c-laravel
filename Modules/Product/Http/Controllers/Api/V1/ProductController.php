<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Modules\Product\Interfaces\Api\V1\ProductRepositoryInterface;
use Modules\Product\Transformers\Api\V1\ProductResource;

class ProductController extends Controller
{
    public ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($categoryId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection($this->repository->index($categoryId));
    }

    public function show($id): ProductResource
    {
        return ProductResource::make($this->repository->show($id));
    }
}
