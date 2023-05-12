<?php

namespace Modules\Address\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Address\Interfaces\CuApi\V1\AddressRepositoryInterface;
use Modules\Address\Entities\Address;

class AddressRepository implements AddressRepositoryInterface
{
    use BaseRepositoryTrait;

    public Address|null $model;

    public function __construct(Address $model = new Address())
    {
        $this->model = $model;
    }

    public function index($columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->get();
    }

    public function store(array $array): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->create(array_merge($array, [
            'user_id' => sanctum()->id
        ]));
    }

    public function show($id, $with = null, $columns = ['*']): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->find($id);
    }

    public function update(array $array, $id): int
    {
        $this->find($id);
        return $this->model->update($array);
    }

    public function destroy($id)
    {
        return $this->model->query()->where('id', $id)->delete();
    }
}
