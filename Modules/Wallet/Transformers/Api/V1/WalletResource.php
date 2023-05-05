<?php

namespace Modules\Wallet\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 */

class WalletResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'balance' => $this->balance,
        ];
    }
}
