<?php

namespace Modules\User\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $token
 * @property mixed $phone
 * @property mixed $name
 * @property mixed $id
 */

class AuthResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'phone' => $this->phone,
            'token' => $this->token,
        ];
    }
}
