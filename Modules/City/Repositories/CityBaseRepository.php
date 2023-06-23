<?php

namespace Modules\City\Repositories;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\City\Entities\City;

class CityBaseRepository
{
    use BaseRepositoryTrait;

    public City|null $model;

    public function __construct(City $model = new City())
    {
        $this->model = $model;
    }

    public function exists($id): bool
    {
        return $this->model->query()->where('id', $id)->exists();
    }
}
