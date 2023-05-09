<?php

namespace Modules\Product\Http\Controllers\CuApi\V1;

use Illuminate\Routing\Controller;
use Modules\Product\Interfaces\CuApi\V1\ProductRepositoryInterface;
use Modules\Product\Transformers\CuApi\V1\OneProductResource;
use Modules\Product\Transformers\CuApi\V1\ProductResource;

class ProductController extends Controller
{
    public ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($categoryId, $cityId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection($this->repository->index($categoryId, $cityId, [
            'id', 'title', 'thumbnail', 'price', 'discount', 'category_id', 'city_id', 'rank',
        ]));
    }

    public function show($id): OneProductResource
    {
        return OneProductResource::make($this->repository->show($id, ['category.parent', 'details']));
    }
}
