<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Interfaces\CuApi\V1\CardRepositoryInterface;

class CardRepository implements CardRepositoryInterface
{
    use BaseRepositoryTrait;

    public Card|null $model;

    public function __construct(Card $model = new Card())
    {
        $this->model = $model;
    }

    public function get($number, $cvv)
    {
        return $this->model->where('number', $number)->where('cvv', $cvv)->where('status', true)->first();
    }
}
