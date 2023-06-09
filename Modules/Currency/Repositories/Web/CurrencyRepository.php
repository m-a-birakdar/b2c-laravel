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

    public function value($key = 'tr')
    {
        $currency = $this->model->query()->where('key', $key)->first();
        if ($currency)
            return $currency->value;
        return 1;
    }
}
