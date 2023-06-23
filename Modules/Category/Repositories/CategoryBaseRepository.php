<?php

namespace Modules\Category\Repositories;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Category\Entities\Category;

class CategoryBaseRepository
{
    use BaseRepositoryTrait;

    public Category|null $model;

    public function __construct(Category $model = new Category())
    {
        $this->model = $model;
    }

    public function exists($id): bool
    {
        return $this->model->query()->where('id', $id)->exists();
    }
}
