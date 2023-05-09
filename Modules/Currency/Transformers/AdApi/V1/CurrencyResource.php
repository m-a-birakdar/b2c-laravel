<?php

namespace Modules\Currency\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $value
 * @property mixed $id
 */

class CurrencyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
        ];
    }
}
