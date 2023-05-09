<?php

namespace Modules\Product\Http\Controllers\AdApi\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

    public function index($categoryId, $cityId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection($this->repository->index($categoryId, $cityId, [
            'id', 'category_id', 'city_id', 'price', 'title', 'sku', 'status', 'thumbnail', 'discount',
        ]));
    }

    public function show($id): OneProductResource
    {
        return OneProductResource::make($this->repository->show($id, ['category.parent', 'details']));
    }
}
