<?php

namespace Modules\Wallet\Repositories\Api\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Wallet\Interfaces\Api\V1\WalletRepositoryInterface;
use Modules\Wallet\Entities\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    use BaseRepositoryTrait;

    public Wallet|null $model;

    public function __construct(Wallet $model = new Wallet())
    {
        $this->model = $model;
    }

    public function show()
    {
        return $this->model->firstOrCreate(
            ['user_id' => sanctum()->id],
            ['balance' => 0],
        );
    }
}
