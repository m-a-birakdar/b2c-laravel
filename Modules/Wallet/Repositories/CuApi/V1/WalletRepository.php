<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
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

    public function send(SendRequest $array): bool
    {
        $user = sanctum();
        $this->executeInTransaction(function () use ($array, $user) {
            $this->make($user, TypeEnum::WITHDRAWAL, $array->amount, $array->fromWallet);
            $this->make((new UserRepository)->find($array->toWallet->user_id), TypeEnum::DEPOSIT, $array->amount, $array->toWallet);
        });
        SendPrivateNotificationJob::dispatch(nCu('wallet', 'title'), nCu('wallet.send_money'), $user->id, 'high');
        SendPrivateNotificationJob::dispatch(nCu('wallet', 'title'), nCu('wallet.send_money'), $array->toWallet->user_id, 'high');
        return true;
    }
}
