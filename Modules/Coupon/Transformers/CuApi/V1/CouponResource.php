<?php

namespace Modules\Coupon\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 */

class CouponResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
