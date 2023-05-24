<?php

namespace Modules\Notification\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $created_at
 * @property mixed $initial
 * @property mixed $body
 * @property mixed $title
 * @property mixed $id
 */

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'body'          => $this->body,
            'initial'       => $this->initial,
            'created_at'    => $this->created_at->diffForHumans(),
        ];
    }
}
