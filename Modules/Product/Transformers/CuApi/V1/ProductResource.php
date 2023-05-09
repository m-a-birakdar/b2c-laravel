<?php

namespace Modules\Product\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $title
 * @property mixed $discount
 * @property mixed $price
 * @property mixed $thumbnail
 * @property mixed $id
 */

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'thumbnail'     => $this->thumbnail,
            'price'         => (double) $this->price,
            'discount'      => $this->discount,
        ];
    }
}
