<?php

namespace Modules\Order\Transformers\CoApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Enums\OrderPaymentMethodEnum;
use Modules\Order\Transformers\AdApi\V1\AddressOrderResource;
use Modules\Order\Transformers\AdApi\V1\UserOrderResource;

/**
 * @property mixed $products
 * @property mixed $address
 * @property mixed $user
 * @property mixed $created_at_human
 * @property mixed $total_amount
 * @property mixed $items_qty
 * @property mixed $items_count
 * @property mixed $payment_method_human
 * @property mixed $status_human
 * @property mixed $sku
 * @property mixed $id
 * @property mixed $payment_method
 */

class ShowOrderResource extends JsonResource
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
            'total_amount'      => $this->payment_method == OrderPaymentMethodEnum::OnDoor->value ? $this->total_amount : 0,
            'created_at'        => $this->created_at_human,
            'user'              => UserOrderResource::make($this->user),
            'address'           => AddressOrderResource::make($this->address),
            'products'          => OrderShowProductsResource::collection($this->products),
        ];
    }
}
