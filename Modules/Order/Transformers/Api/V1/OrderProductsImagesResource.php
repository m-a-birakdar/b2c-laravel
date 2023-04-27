<?php

namespace Modules\Order\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $thumbnail
 */

class OrderProductsImagesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'thumbnail' => $this->thumbnail,
        ];
    }
}
