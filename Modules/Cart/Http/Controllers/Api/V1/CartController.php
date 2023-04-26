<?php

namespace Modules\Cart\Http\Controllers\Api\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Cart\Interfaces\Api\V1\CartRepositoryInterface;
use Modules\Cart\Transformers\Api\V1\CartResource;

class CartController extends Controller
{
    public CartRepositoryInterface $repository;

    public function __construct(CartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): CartResource
    {
        return CartResource::make($this->repository->index());
    }

    public function add($productId): MainResource
    {
        return MainResource::make($this->repository->add($productId));
    }

    public function remove($productId): MainResource
    {
        return MainResource::make($this->repository->remove($productId));
    }
}
