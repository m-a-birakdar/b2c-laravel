<?php

namespace Modules\Cart\Repositories\Web;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Cart\Interfaces\Web\CartRepositoryInterface;
use Modules\Cart\Entities\Cart;

class CartRepository implements CartRepositoryInterface
{
    use BaseRepositoryTrait;

    public Cart|null $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function index($columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->get();
    }

    public function store(array $array): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->create($array);
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
}
