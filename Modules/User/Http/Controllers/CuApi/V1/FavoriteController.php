<?php

namespace Modules\User\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Transformers\CuApi\V1\ProductResource;
use Modules\User\Interfaces\CuApi\V1\FavoriteRepositoryInterface;

class FavoriteController extends Controller
{
    public FavoriteRepositoryInterface $repository;

    public function __construct(FavoriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection($this->repository->index());
    }

    public function toggle($status, Product $product): MainResource
    {
        return MainResource::make(null, $this->repository->toggle($status, $product->id));
    }
}
