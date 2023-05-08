<?php

namespace Modules\Currency\Repositories\Web;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Currency\Interfaces\Web\CurrencyRepositoryInterface;
use Modules\Currency\Entities\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    use BaseRepositoryTrait;

    public Currency|null $model;

    public function __construct(Currency $model = new Currency())
    {
        $this->model = $model;
    }

    public function value()
    {
        return $this->model->first()->value;
    }
}
