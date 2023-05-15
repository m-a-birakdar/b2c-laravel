<?php

namespace Modules\Order\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $products
 * @property mixed $address
 * @property mixed $user
 * @property mixed $created_at_human
 * @property mixed $total_amount
 * @property mixed $discount_amount
 * @property mixed $items_amount
 * @property mixed $shipping_amount
 * @property mixed $items_qty
 * @property mixed $items_count
 * @property mixed $payment_method_human
 * @property mixed $status_human
 * @property mixed $sku
 * @property mixed $id
 */

class OneOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'sku'               => $this->sku,
            'status'            => $this->status_human,
            'payment_method'    => $this->payment_method_human,
            'items_count'       => $this->items_count,
            'items_qty'         => $this->items_qty,
            'shipping_amount'   => $this->shipping_amount,
            'items_amount'      => $this->items_amount,
            'discount_amount'   => $this->discount_amount,
            'total_amount'      => $this->total_amount,
            'created_at'        => $this->created_at_human,
            'user'              => UserOrderResource::make($this->user),
            'address'           => AddressOrderResource::make($this->address),
            'products'          => OrderShowProductsResource::collection($this->products),
        ];
    }
}
