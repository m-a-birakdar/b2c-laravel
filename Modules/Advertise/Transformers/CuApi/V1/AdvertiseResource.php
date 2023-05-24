<?php

namespace Modules\Advertise\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $redirect_in
 * @property mixed $type
 * @property mixed $url
 * @property mixed $image
 */

class AdvertiseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'image' => $this->image,
            'url' => $this->url,
            'type' => $this->type,
            'redirect_in' => $this->redirect_in,
        ];
    }
}
