<?php

namespace Modules\Order\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $products
 * @property mixed $created_at_human
 * @property mixed $total_amount
 * @property mixed $items_qty
 * @property mixed $items_count
 * @property mixed $status_human
 * @property mixed $sku
 * @property mixed $id
 * @property mixed $review_exists
 */

class OrderShowResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'status' => $this->status_human,
            'all_status' => all_order_status(),
            'items_count' => $this->items_count,
            'items_qty' => $this->items_qty,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at_human,
            'review_exists' => $this->review_exists,
            'products' => OrderShowProductsResource::collection($this->products),
        ];
    }
}
