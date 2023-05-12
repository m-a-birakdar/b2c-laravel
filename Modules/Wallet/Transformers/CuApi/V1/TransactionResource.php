<?php

namespace Modules\Wallet\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at_human
 * @property mixed $amount
 * @property mixed $type
 * @property mixed $source
 * @property mixed $id
 */

class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'source'        => $this->source,
            'type'          => $this->type,
            'amount'        => $this->amount,
            'created_at'    => $this->created_at_human,
        ];
    }
}
