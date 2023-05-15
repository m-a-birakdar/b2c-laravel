<?php

namespace Modules\Order\Transformers\AdApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $address
 * @property mixed $user
 * @property mixed $created_at_human
 * @property mixed $total_amount
 * @property mixed $status_human
 * @property mixed $id
 */

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'status'        => $this->status_human,
            'total_amount'  => $this->total_amount,
            'created_at'    => $this->created_at_human,
            'user'          => UserOrderResource::make($this->user),
            'address'       => AddressOrderResource::make($this->address),
        ];
    }
}
