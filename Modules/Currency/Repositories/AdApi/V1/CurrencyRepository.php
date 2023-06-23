<?php

namespace Modules\Currency\Repositories\AdApi\V1;

use Modules\Currency\Interfaces\AdApi\V1\CurrencyRepositoryInterface;
use Modules\Currency\Repositories\CurrencyBaseRepository;

class CurrencyRepository extends CurrencyBaseRepository implements CurrencyRepositoryInterface
{
    public function show($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->find($id);
    }

    public function update(array $array, $id): bool
    {
        $this->find($id);
        return $this->model->update($array);
    }
}
