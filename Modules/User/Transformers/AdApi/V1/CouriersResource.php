<?php

namespace Modules\User\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $phone
 * @property mixed $name
 * @property mixed $id
 */

class CouriersResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'phone' => $this->phone,
        ];
    }
}
