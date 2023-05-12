<?php

namespace Modules\Order\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $thumbnail
 * @property mixed $pivot
 * @property mixed $title
 * @property mixed $id
 */

class OrderShowProductsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'price'     => $this->pivot->total_price,
            'quantity'  => $this->pivot->quantity,
            'thumbnail' => $this->thumbnail,
        ];
    }
}
