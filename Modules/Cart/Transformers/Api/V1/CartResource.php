<?php

namespace Modules\Cart\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $products
 * @property mixed $items_qty
 * @property mixed $items_count
 */

class CartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'items_count' => $this->items_count,
            'items_qty' => $this->items_qty,
            'products' => CartProductsResource::collection($this->products),
        ];
    }
}
