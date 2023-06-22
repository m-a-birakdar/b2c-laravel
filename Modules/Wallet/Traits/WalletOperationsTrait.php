<?php

namespace Modules\Wallet\Traits;

use Illuminate\Support\Facades\DB;
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
        DB::transactionLevel() > 0 ?
            $this->queries() :
            $this->executeInTransaction(function (){
                $this->queries();
            });
    }

    private function queries(): void
    {
        $this->makeWallet();
        $this->makeTransaction();
    }

    protected function makeWallet(): void
    {
        $this->wallet->update([
            'balance' => $this->wallet->balance + ($this->type == TypeEnum::DEPOSIT->value ? $this->amount : - $this->amount )
        ]);
    }

    protected function makeTransaction(): void
    {
        $this->mainModel->transaction()->create([
            'wallet_id' => $this->wallet->id, 'type' => $this->type, 'amount' => $this->amount
        ]);
    }
}
