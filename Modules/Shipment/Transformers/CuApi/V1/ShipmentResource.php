<?php

namespace Modules\Shipment\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Address\Transformers\CuApi\V1\AddressResource;

/**
 * @property mixed $name
 * @property mixed $created_at_human
 * @property mixed $address
 * @property mixed $user
 * @property mixed $status_human
 * @property mixed $track_number
 * @property mixed $customer
 */

class ShipmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'track_number'          => $this->track_number,
            'status'                => $this->status_human,
            'all_shipment_status'   => all_shipment_status(),
            'customer'              => ShipmentUserResource::make($this->customer),
            'address'               => AddressResource::make($this->address),
            'created_at'            => $this->created_at_human,
        ];
    }
}
