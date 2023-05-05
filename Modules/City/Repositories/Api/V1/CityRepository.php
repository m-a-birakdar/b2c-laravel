<?php

namespace Modules\City\Repositories\Api\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\City\Interfaces\Api\V1\CityRepositoryInterface;
use Modules\City\Entities\City;

class CityRepository implements CityRepositoryInterface
{
    use BaseRepositoryTrait;

    public City|null $model;

    public function __construct(City $model)
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
