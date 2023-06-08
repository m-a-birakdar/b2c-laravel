<?php

namespace Modules\Category\Repositories\Web;

use App\Traits\MediaTrait;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Category\Interfaces\Web\CategoryRepositoryInterface;
use Modules\Category\Entities\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    use BaseRepositoryTrait, MediaTrait;

    public Category|null $model;

    public function __construct(Category $model = new Category())
    {
        $this->model = $model;
    }

    public function index($columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->get();
    }

    public function store(array $array): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $array['image'] = $this->uploadImage($array['image_file'], 'categories');
        return $this->model->query()->create($array);
    }

    public function show($id, $with = null, $columns = ['*']): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->find($id);
    }

    public function update(array $array, $id): int
    {
        $this->find($id);
        if (array_key_exists('image_file', $array) && !is_null($array['image_file'])){
            $array['image'] = $this->uploadImage($array['image_file'], 'categories');
            $this->unlinkImage('categories' . $this->model->image);
        }
        return $this->model->query()->where('id', $id)->update($array);
    }

    public function destroy($id): ?bool
    {
        if (! is_null($this->model->image))
            $this->unlinkImage('categories' . $this->model->image);
        return $this->model->delete();
    }

    public function checkBeforeDelete($id): bool
    {
        $this->find($id);
        return $this->model->subCategories()->exists();
    }

    public function exists($id): bool
    {
        return $this->model->query()->where('id', $id)->exists();
    }
}
