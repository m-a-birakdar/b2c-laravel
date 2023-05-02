<?php

namespace Modules\Support\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 */

class SupportResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
