<?php

namespace Modules\Shipment\Transformers\CoApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $created_at_human
 * @property mixed $address
 * @property mixed $user
 * @property mixed $status_human
 * @property mixed $track_number
 * @property mixed $order
 * @property mixed $customer
 */

class ShipmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'track_number'  => $this->track_number,
            'status'        => $this->status_human,
            'user'          => CustomerResource::make($this->customer),
            'order'         => OrderResource::make($this->order),
            'address'       => AddressResource::make($this->address),
            'created_at'    => $this->created_at_human,
        ];
    }
}
