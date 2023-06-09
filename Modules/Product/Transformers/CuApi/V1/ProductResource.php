<?php

namespace Modules\Product\Transformers\CuApi\V1;

use Modules\Currency\Repositories\Web\CurrencyRepository;
use Modules\Product\Transformers\ProductBaseResource;

/**
 * @property mixed $title
 * @property mixed $discount
 * @property mixed $price
 * @property mixed $thumbnail
 * @property mixed $id
 */

class ProductResource extends ProductBaseResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'thumbnail' => $this->thumbnail,
            'price'     => (double) $this->price * self::$currency,
            'discount'  => $this->discount,
        ];
    }
}
