<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Wallet\Interfaces\CuApi\V1\WalletRepositoryInterface;
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
            ['balance' => 0, 'number' => $this->generateNumber()],
        );
    }

    private function generateNumber(): string
    {
        $exists = true;
        $new = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
        while ($exists)
            $exists = $this->model->where('number', $new)->exists();
        return $new;
    }
}
