<?php

namespace Modules\Product\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Transformers\CuApi\V1\OneProductCategoryResource;

/**
 * @property mixed $details
 * @property mixed $category
 * @property mixed $sku
 * @property mixed $discount
 * @property mixed $lira_price
 * @property mixed $price
 * @property mixed $thumbnail
 * @property mixed $title
 * @property mixed $id
 * @property mixed $status
 */

class OneProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'status'        => $this->status,
            'title'         => $this->title,
            'thumbnail'     => $this->thumbnail,
            'dollar_price'  => (double) $this->price,
            'lira_price'    => (double) $this->lira_price,
            'discount'      => $this->discount,
            'sku'           => $this->sku,
            'category'      => OneProductCategoryResource::make($this->category),
            'description'   => $this->details->description,
            'quantity'      => $this->details->quantity,
        ];
    }
}
