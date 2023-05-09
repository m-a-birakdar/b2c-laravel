<?php

namespace Modules\Product\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $discount
 * @property mixed $lira_price
 * @property mixed $price
 * @property mixed $thumbnail
 * @property mixed $status
 * @property mixed $sku
 * @property mixed $title
 * @property mixed $id
 */

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'sku'           => $this->sku,
            'status'        => $this->status,
            'thumbnail'     => $this->thumbnail,
            'dollar_price'  => (double) $this->price,
            'lira_price'  => (double) $this->lira_price,
            'discount'      => $this->discount,
        ];
    }
}
