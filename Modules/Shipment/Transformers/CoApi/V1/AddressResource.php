<?php

namespace Modules\Shipment\Transformers\CoApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $address
 * @property mixed $id
 */

class AddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
        ];
    }
}
