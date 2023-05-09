<?php

namespace Modules\User\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 */

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
