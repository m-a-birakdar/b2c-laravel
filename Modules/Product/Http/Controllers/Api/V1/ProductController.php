<?php

namespace Modules\Product\Http\Controllers\Api\V1;

use Modules\Product\Http\Requests\Api\V1\ProductRequest;
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

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection($this->repository->index());
    }

    public function store(ProductRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): ProductResource
    {
        return ProductResource::make($this->repository->show($id));
    }

    public function update(ProductRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
