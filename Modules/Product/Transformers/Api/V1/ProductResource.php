<?php

namespace Modules\Product\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $title
 * @property mixed $discount
 * @property mixed $price
 * @property mixed $thumbnail
 * @property mixed $status
 * @property mixed $sku
 * @property mixed $category_id
 */

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title'         => $this->title,
            'category_id'   => $this->category_id,
            'sku'           => $this->sku,
            'status'        => $this->status,
            'thumbnail'     => $this->thumbnail,
            'price'         => (double) $this->price,
            'discount'      => $this->discount,
        ];
    }
}
