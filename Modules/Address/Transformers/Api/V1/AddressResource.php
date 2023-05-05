<?php

namespace Modules\Address\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $address
 * @property mixed $city
 * @property mixed $id
 */

class AddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city->name,
            'address' => $this->address,
        ];
    }
}
