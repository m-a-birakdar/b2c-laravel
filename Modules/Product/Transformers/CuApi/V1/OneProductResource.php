<?php

namespace Modules\Product\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $details
 * @property mixed $category
 * @property mixed $sku
 * @property mixed $discount
 * @property mixed $price
 * @property mixed $thumbnail
 * @property mixed $title
 * @property mixed $id
 */

class OneProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'thumbnail'     => $this->thumbnail,
            'price'         => (double) $this->price,
            'discount'      => $this->discount,
            'sku'           => $this->sku,
            'category'      => OneProductCategoryResource::make($this->category),
            'description'   => $this->details->description,
        ];
    }
}
