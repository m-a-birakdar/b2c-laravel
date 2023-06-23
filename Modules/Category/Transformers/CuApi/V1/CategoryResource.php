<?php

namespace Modules\Category\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $image
 * @property mixed $status
 * @property mixed $parent_id
 * @property mixed $id
 */

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'parent_id' => $this->parent_id,
        ];
    }
}
