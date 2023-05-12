<?php

namespace Modules\Cart\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $thumbnail
 * @property mixed $discount
 * @property mixed $price
 * @property mixed $title
 * @property mixed $id
 * @property mixed $pivot
 */

class CartProductsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'discount' => $this->discount,
            'thumbnail' => $this->thumbnail,
            'quantity' => $this->pivot->quantity,
        ];
    }
}
