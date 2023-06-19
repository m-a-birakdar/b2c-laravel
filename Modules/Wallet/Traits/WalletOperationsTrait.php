<?php

namespace Modules\Wallet\Traits;

use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Repositories\CuApi\V1\WalletRepository;

trait WalletOperationsTrait
{
    private $mainModel, $wallet, $type, $amount;

    public function make($model, $type, $amount, $wallet = null): void
    {
        $this->mainModel = $model;
        $this->type = $type;
        $this->amount = $amount;
        $this->wallet = $wallet ?: ( new WalletRepository() )->show();
        $this->makeWallet();
        $this->makeTransaction();
    }

    protected function makeWallet(): void
    {
        if ($this->type == TypeEnum::DEPOSIT->value)
            $balance = $this->wallet->balance + $this->amount;
        else
            $balance = $this->wallet->balance - $this->amount;
        $this->wallet->update([
            'balance' => $balance
        ]);
    }

    protected function makeTransaction(): void
    {
        $this->mainModel->transaction()->create([
            'wallet_id' => $this->wallet->id, 'type' => $this->type, 'amount' => $this->amount
        ]);
    }
}
