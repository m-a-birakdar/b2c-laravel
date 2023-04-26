<?php

namespace Modules\Cart\Repositories\Api\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Interfaces\Api\V1\CartRepositoryInterface;
use Modules\Cart\Entities\Cart;

class CartRepository implements CartRepositoryInterface
{
    use BaseRepositoryTrait;

    public Cart|null $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->findWhere('user_id', auth('sanctum')->id(), [
            'products:id,title,price,discount,thumbnail'
        ]);
    }

    public function getCartAndItems($productId, $add = true): array
    {
        $user = auth('sanctum')->user();
        $cart = $this->findWhere('user_id', $user->id);
        if (is_null($cart) && $add)
            $cart = $user->cart()->create(['items_count' => 0, 'items_qty' => 0]);
        $item = $cart->items()->where('product_id', $productId)->first();
        return [$cart, $item];
    }

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
