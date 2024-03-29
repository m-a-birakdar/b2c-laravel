<?php

namespace Modules\Invoice\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 */

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
