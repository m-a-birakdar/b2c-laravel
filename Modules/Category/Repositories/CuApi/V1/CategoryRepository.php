<?php

namespace Modules\Category\Repositories\CuApi\V1;

use Modules\Category\Interfaces\CuApi\V1\CategoryRepositoryInterface;
use Modules\Category\Repositories\CategoryBaseRepository;

class CategoryRepository extends CategoryBaseRepository implements CategoryRepositoryInterface
{
    public function main($columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->available()->whereNull('parent_id')->orderBy('rank')->get($columns);
    }

    public function sub($categoryId, $columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->available()->where('parent_id', $categoryId)->orderBy('rank')->get($columns);
    }
}
