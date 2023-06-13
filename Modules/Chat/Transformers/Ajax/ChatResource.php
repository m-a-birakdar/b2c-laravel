<?php

namespace Modules\Chat\Transformers\Ajax;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 * @property mixed $text
 * @property mixed $receipt_id
 * @property mixed $sender_id
 */
class ChatResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'sender_id'     => $this->sender_id,
            'receipt_id'    => $this->receipt_id,
            'text'          => $this->text,
            'created_at'    => Carbon::createFromTimestampMs($this->created_at)->format('H:i:s'),
        ];
    }
}
