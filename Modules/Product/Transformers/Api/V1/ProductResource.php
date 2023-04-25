<?php

namespace Modules\Product\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $title
 */

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'category_id' => $this->category_id,
            'sku' => $this->sku,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'price' => $this->price,
            'discount' => $this->discount,
        ];
    }
}
