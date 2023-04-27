<?php

namespace Modules\Order\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $products
 * @property mixed $sku
 * @property mixed $id
 * @property mixed $created_at_human
 * @property mixed $status_human
 * @property mixed $total_amount
 */

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'status' => $this->status_human,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at_human,
            'products' => OrderProductsImagesResource::collection($this->products),
        ];
    }
}
