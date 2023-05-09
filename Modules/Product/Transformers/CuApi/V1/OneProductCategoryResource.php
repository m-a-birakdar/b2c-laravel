<?php

namespace Modules\Product\Transformers\CuApi\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $parent
 * @property mixed $name
 * @property mixed $id
 */

class OneProductCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => OneProductCategoryResource::make($this->parent),
        ];
    }
}
