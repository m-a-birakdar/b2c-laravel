<?php

namespace Modules\Shipment\Transformers\CoApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at_human
 * @property mixed $status_human
 * @property mixed $track_number
 * @property mixed $id
 */

class AllShipmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'track_number'  => $this->track_number,
            'status'        => $this->status_human,
            'created_at'    => $this->created_at_human,
        ];
    }
}
