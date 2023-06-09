<?php

namespace Modules\Product\Http\Controllers\AdApi\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Product\Interfaces\AdApi\V1\ProductRepositoryInterface;
use Modules\Product\Transformers\AdApi\V1\OneProductResource;
use Modules\Product\Transformers\AdApi\V1\ProductResource;

class ProductController extends Controller
{
    public ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($categoryId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::customCollection($this->repository->index($categoryId));
    }

    public function show($id): OneProductResource
    {
        return OneProductResource::make($this->repository->show($id));
    }

    public function search(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        abort_if(! $request->has('text') || Str::length($request->input('text')) == 0, 404);
        return ProductResource::customCollection($this->repository->search());
    }
}
