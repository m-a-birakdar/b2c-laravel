<?php

namespace Modules\Cart\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Cart\Entities\CartItem;
use Modules\Cart\Interfaces\CuApi\V1\CartRepositoryInterface;
use Modules\Cart\Entities\Cart;
use Modules\Product\Enums\StatisticsEnum;
use Modules\Product\Jobs\ProductStatisticsJob;
use Modules\User\Entities\User;

class CartRepository extends DBTransactionRepository implements CartRepositoryInterface
{
    use BaseRepositoryTrait;

    public Cart|null $model;

    public User|null $user;

    public CartItem|null $cartItem;

    public function __construct(Cart $model = new Cart())
    {
        $this->model = $model;
    }

    public function allowCheckout(): bool
    {
        $this->model = $this->findWhere('user_id', sanctum()->id, [
            'products:id,title,price,discount,thumbnail'
        ]);
        return $this->model && count($this->model->products) != 0;
    }

    public function checkout(): ?Cart
    {
        $shippingLimitPrice = 1000;
        $shippingPrice = 25;
        $totalAmount = 0;
        foreach ($this->model->products as $product)
            $totalAmount += $product->price * $product->pivot->quantity;
        $this->model->update([
            'shipping_amount' => $totalAmount > $shippingLimitPrice ? 0 : $shippingPrice,
            'items_amount' => $totalAmount,
            'checkout_at' => now()
        ]);
        return $this->model;
    }

    public function index()
    {
        return $this->findWhere('user_id', sanctum()->id, [
            'products:id,title,price,discount,thumbnail'
        ]);
    }

    public function getCartAndItems($productId, $add = true)
    {
        $this->user = sanctum();
        $this->findWhere('user_id', $this->user->id);
        if (is_null($this->model) && $add)
            $this->model = ( new Cart() )->create(['user_id' => $this->user->id, 'items_count' => 0, 'items_qty' => 0]);
        $this->cartItem = $this->model?->items()?->where('product_id', $productId)->first();
    }

    public function add($productId): bool
    {
        $this->getCartAndItems($productId);
        $this->executeInTransaction(function () use ($productId) {
            if (is_null($this->cartItem)){
                $this->model->items()->create([
                    'product_id' => $productId,
                    'quantity' => 1
                ]);
                $this->updateCart();
            } else {
                $this->incrementOrDecrement();
            }
        });
        ProductStatisticsJob::dispatch($productId, $this->user->id, StatisticsEnum::AddToCart, time());
        return true;
    }

    public function remove($productId): bool
    {
        $this->getCartAndItems($productId, false);
        $this->executeInTransaction(function () use ($productId) {
            if ($this->model->items_qty > 1){
                if ($this->cartItem->quantity > 1){
                    $this->incrementOrDecrement('decrement');
                } else {
                    $this->cartItem->delete();
                    $this->updateCart('-');
                }
            } else {
                $this->cartItem->delete();
                $this->model->delete();
            }
        });
        ProductStatisticsJob::dispatch($productId, $this->user->id, StatisticsEnum::RemoveFromCart, time());
        return true;
    }

    private function incrementOrDecrement($stats = 'increment')
    {
        $this->cartItem->{$stats}('quantity');
        $this->model->{$stats}('items_qty');
    }

    private function updateCart($opp = '+')
    {
        $this->model->update([
            'items_count' => $this->model->items_count + ($opp == '+' ? 1 : - 1),
            'items_qty' => $this->model->items_qty + ($opp == '+' ? 1 : - 1),
        ]);
    }

    public function allowRemove($productId): bool
    {
        $this->getCartAndItems($productId, false);
        return $this->model && $this->cartItem;
    }

    public function flush()
    {
        $this->user = sanctum();
        $this->findWhere('user_id', $this->user->id);
        return $this->executeInTransaction(function () {
            foreach ($this->model?->items ?? [] as $item)
                $item->delete();
            $this->model?->delete();
            return true;
        });
    }
}
