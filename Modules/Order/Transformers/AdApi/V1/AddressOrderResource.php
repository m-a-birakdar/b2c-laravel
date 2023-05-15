<?php

namespace Modules\Order\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $address
 * @property mixed $id
 */

class AddressOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'address'  => $this->address,
        ];
    }
}
