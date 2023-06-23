<?php

namespace Modules\Currency\Repositories;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Currency\Entities\Currency;

class CurrencyBaseRepository
{
    use BaseRepositoryTrait;

    public Currency|null $model;

    public function __construct(Currency $model = new Currency())
    {
        $this->model = $model;
    }

    public function exists($id): bool
    {
        return $this->model->query()->where('id', $id)->exists();
    }

}
