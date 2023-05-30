<?php

namespace Modules\User\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 */

class WelcomeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->id
        ];
    }
}
