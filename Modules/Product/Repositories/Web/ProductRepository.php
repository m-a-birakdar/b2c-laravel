<?php

namespace Modules\Product\Repositories\Web;

use App\Traits\MediaTrait;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Product\Interfaces\Web\ProductRepositoryInterface;
use Modules\Product\Entities\Product;

class ProductRepository implements ProductRepositoryInterface
{
    use BaseRepositoryTrait, MediaTrait;

    public Product|null $model;

    public function __construct(Product $model = new Product())
    {
        $this->model = $model;
    }

    public function index($columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->get();
    }

    public function store(array $array)
    {
        $data = array_merge($array, [
            'thumbnail' =>  $this->uploadImage($array['featured_image'])
        ]);
        $this->model = $this->model->create($data);
        $this->model->details()->create($data);
    }

    public function show($id, $with = null, $columns = ['*'])
    {
        // TODO: Implement show() method.
    }

    public function update(array $array, $id): int
    {
        return $this->model->query()->where('id', $id)->update($array);
    }

    public function destroy($id)
    {
        return $this->model->query()->where('id', $id)->delete();
    }

    public function exists($id): bool
    {
        return $this->model->query()->where('id', $id)->exists();
    }
}
