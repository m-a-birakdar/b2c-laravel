<?php

namespace Modules\Product\Transformers\AdApi\V1;

use Modules\Product\Transformers\ProductBaseResource;

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

class ProductResource extends ProductBaseResource
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
            'lira_price'    => (double) $this->price * self::$currency,
            'discount'      => $this->discount,
        ];
    }
}
