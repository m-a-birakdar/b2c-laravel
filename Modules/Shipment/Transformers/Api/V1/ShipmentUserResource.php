<?php

namespace Modules\Shipment\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $phone
 */

class ShipmentUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'phone' => $this->phone,
            'name' => $this->name,
        ];
    }
}
