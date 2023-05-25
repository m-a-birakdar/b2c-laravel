<?php

namespace Modules\Cart\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $products
 * @property mixed $items_qty
 * @property mixed $items_count
 * @property mixed $id
 * @property mixed $items_amount
 * @property mixed $shipping_amount
 */

class CartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'cart_id'           => $this->id,
            'shipping_amount'   => $this->shipping_amount,
            'items_amount'      => $this->items_amount,
            'items_count'       => $this->items_count,
            'items_qty'         => $this->items_qty,
            'products'          => CartProductsResource::collection($this->products),
        ];
    }
}
