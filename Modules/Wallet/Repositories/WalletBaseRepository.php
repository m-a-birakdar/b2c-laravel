<?php

namespace Modules\Wallet\Repositories;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Wallet\Entities\Wallet;

class WalletBaseRepository
{
    use BaseRepositoryTrait;

    public Wallet|null $model;

    public function __construct(Wallet $model = new Wallet())
    {
        $this->model = $model;
    }

    public function findByNumber($number)
    {
        return $this->model->query()->where('number', $number)->first();
    }

//    public function allowNumberToSend($number, $id): bool
//    {
//        return $this->model->query()->where('number', $number)->where('id', '!=', $id)->exists();
//    }
}
