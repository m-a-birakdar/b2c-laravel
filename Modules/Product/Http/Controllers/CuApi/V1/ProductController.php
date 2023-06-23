<?php

namespace Modules\Product\Http\Controllers\CuApi\V1;

use App\Traits\ModelExistsTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Product\Interfaces\CuApi\V1\ProductRepositoryInterface;
use Modules\Product\Transformers\CuApi\V1\OneProductResource;
use Modules\Product\Transformers\CuApi\V1\ProductResource;

class ProductController extends Controller
{
    use ModelExistsTrait;

    public ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($categoryId, $cityId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->exists(['category' => $categoryId, 'city' => $cityId]);
        return ProductResource::customCollection($this->repository->index($categoryId, $cityId));
    }

    public function show($id, $userId): OneProductResource
    {
        $this->exists(['product' => $id, 'user' => $userId]);
        return OneProductResource::make($this->repository->show($id, $userId));
    }

    public function search($cityId, $userId, Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->exists(['city' => $cityId, 'user' => $userId]);
        $this->checkParameter(! $request->has('text') || Str::length($request->input('text')) == 0);
        return ProductResource::customCollection($this->repository->search($cityId, $userId));
    }

    public function related($categoryId, $cityId, $id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->exists(['city' => $cityId, 'category' => $categoryId, 'product' => $id]);
        return ProductResource::customCollection($this->repository->related($categoryId, $cityId, $id));
    }
}
