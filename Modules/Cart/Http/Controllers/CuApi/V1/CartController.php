<?php

namespace Modules\Cart\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use App\Traits\ModelExistsTrait;
use Illuminate\Routing\Controller;
use Modules\Cart\Interfaces\CuApi\V1\CartRepositoryInterface;
use Modules\Cart\Transformers\CuApi\V1\CartResource;
use Modules\Product\Repositories\ProductBaseRepository;

class CartController extends Controller
{
    use ModelExistsTrait;

    public CartRepositoryInterface $repository;

    public function __construct(CartRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): CartResource|MainResource
    {
        return $this->repository->index() ? CartResource::make($this->repository->index()) : MainResource::make(null, false, nCu('cart', 'your_cart_is_empty'));
    }

    public function checkout(): CartResource|MainResource
    {
        return $this->repository->allowCheckout() ? CartResource::make($this->repository->checkout()) : MainResource::make(null, false);
    }

    public function flush(): MainResource
    {
        return MainResource::make(null, $this->repository->flush());
    }

    public function add($productId): MainResource
    {
        $this->exists(new ProductBaseRepository, $productId);
        return MainResource::make(null, $this->repository->add($productId));
    }

    public function remove($productId): MainResource
    {
        $this->exists(new ProductBaseRepository, $productId);
        return MainResource::make(null, $this->repository->allowRemove($productId) ? $this->repository->remove($productId) : false);
    }
}
