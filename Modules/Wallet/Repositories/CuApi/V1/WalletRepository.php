<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\User\Repositories\CuApi\V1\UserRepository;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Http\Requests\CuApi\V1\SendRequest;
use Modules\Wallet\Interfaces\CuApi\V1\WalletRepositoryInterface;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Traits\WalletOperationsTrait;

class WalletRepository extends DBTransactionRepository implements WalletRepositoryInterface
{
    use BaseRepositoryTrait, WalletOperationsTrait;

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

    public function send(SendRequest $array)
    {
        return $this->executeInTransaction(function () use ($array) {
            $this->make(sanctum(), TypeEnum::WITHDRAWAL->value, $array->amount, $array->fromWallet);
            $this->make((new UserRepository)->find($array->toWallet->user_id), TypeEnum::DEPOSIT->value, $array->amount, $array->toWallet);
            return true;
        });
    }
}
