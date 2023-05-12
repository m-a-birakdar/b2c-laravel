<?php

namespace Modules\Cart\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Interfaces\CuApi\V1\CartRepositoryInterface;
use Modules\Cart\Entities\Cart;

class CartRepository implements CartRepositoryInterface
{
    use BaseRepositoryTrait;

    public Cart $model;

    public function __construct()
    {
        $this->model = new Cart();
    }

    public function checkout()
    {
        $cart = $this->findWhere('user_id', sanctum()->id, [
            'products:id,title,price,discount,thumbnail'
        ]);
        $shippingLimitPrice = 1000;
        $shippingPrice = 25;
        $totalAmount = 0;
        foreach ($cart->products as $product)
            $totalAmount += $product->price * $product->pivot->quantity;
        $cart->update([
            'shipping_amount' => $totalAmount > $shippingLimitPrice ? 0 : $shippingPrice,
            'items_amount' => $totalAmount
        ]);
        return $cart;
    }

    public function index()
    {
        return $this->findWhere('user_id', sanctum()->id, [
            'products:id,title,price,discount,thumbnail'
        ]);
    }

    public function getCartAndItems($productId, $add = true): array
    {
        $user = sanctum();
        $cart = $this->findWhere('user_id', $user->id);
        if (is_null($cart) && $add)
            $cart = $user->cart()->create(['items_count' => 0, 'items_qty' => 0]);
        $item = $cart->items()->where('product_id', $productId)->first();
        return [$cart, $item];
    }

    /**
     * @throws ApiErrorException
     */
    public function add($productId): bool
    {
        DB::beginTransaction();
        try {
            list($cart, $item) = $this->getCartAndItems($productId);
            if (is_null($item)){
                $cart->products()->attach($productId, [
                    'quantity' => 1
                ]);
                $cart->incrementEach(['items_count' => 1, 'items_qty' => 1]);
            } else {
                $item->increment('quantity');
                $cart->increment('items_qty');
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function remove($productId): bool
    {
        DB::beginTransaction();
        try {
            list($cart, $item) = $this->getCartAndItems($productId, false);
            if ($cart->items_qty > 1){
                if ($item->quantity > 1){
                    $item->decrement('quantity');
                    $cart->decrement('items_qty');
                } else {
                    $item->delete();
                    $cart->decrementEach(['items_count' => 1, 'items_qty' => 1]);
                }
            } else {
                $item->delete();
                $cart->delete();
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }
}
