<?php

namespace Modules\Shipment\Transformers\CoApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $items_qty
 * @property mixed $items_count
 * @property mixed $payment_method_human
 * @property mixed $sku
 * @property mixed $id
 */

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'payment_method' => $this->payment_method_human,
            'items_count' => $this->items_count,
            'items_qty' => $this->items_qty,
        ];
    }
}
