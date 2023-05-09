<?php

namespace Modules\Currency\Repositories\AdApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Currency\Entities\Currency;
use Modules\Currency\Interfaces\AdApi\V1\CurrencyRepositoryInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    use BaseRepositoryTrait;

    public Currency|null $model;

    public function __construct(Currency $model)
    {
        $this->model = $model;
    }

    public function show($id)
    {
        $this->find($id);
        return $this->model;
    }

    public function update(array $array, $id)
    {
        $this->find($id);
        return $this->model->update($array);
    }
}
