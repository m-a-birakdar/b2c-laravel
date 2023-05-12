<?php

namespace Modules\Category\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Category\Interfaces\CuApi\V1\CategoryRepositoryInterface;
use Modules\Category\Entities\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    use BaseRepositoryTrait;

    public Category|null $model;

    public function __construct(Category $model = new Category())
    {
        $this->model = $model;
    }

    public function main($columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->available()->whereNull('parent_id')->orderBy('rank')->get($columns);
    }

    public function sub($categoryId, $columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->available()->where('parent_id', $categoryId)->orderBy('rank')->get($columns);
    }
}
