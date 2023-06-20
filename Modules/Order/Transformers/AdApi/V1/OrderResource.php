<?php

namespace Modules\Order\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $address
 * @property mixed $user
 * @property mixed $created_at_human
 * @property mixed $total_amount
 * @property mixed $status_human
 * @property mixed $id
 * @property mixed $shipment_exists
 * @property mixed $sku
 */

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'sku'               => $this->sku,
            'status'            => $this->status_human,
            'total_amount'      => $this->total_amount,
            'created_at'        => $this->created_at,
            'assign_courier'    => (bool) $this->shipment,
            'user'              => UserOrderResource::make($this->user),
            'address'           => AddressOrderResource::make($this->address),
        ];
    }
}
