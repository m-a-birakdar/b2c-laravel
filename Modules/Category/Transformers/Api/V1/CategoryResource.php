<?php

namespace Modules\Category\Transformers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $rank
 * @property mixed $image
 * @property mixed $status
 * @property mixed $parent_id
 */

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'image' => $this->image,
            'rank' => $this->rank,
            'parent_id' => $this->parent_id,
        ];
    }
}
