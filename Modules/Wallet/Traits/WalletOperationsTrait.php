<?php

namespace Modules\Wallet\Traits;

use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\Order;
use Modules\Shipment\Entities\Shipment;
use Modules\User\Entities\User;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Repositories\CuApi\V1\WalletRepository;

trait WalletOperationsTrait
{
    private User|Shipment|Card|Order $mainModel;
    private TypeEnum $type;
    private Wallet|null $wallet;
    private int|float $amount;

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
            'balance' => $this->wallet->balance + ($this->type == TypeEnum::DEPOSIT ? $this->amount : - $this->amount )
        ]);
    }

    protected function makeTransaction(): void
    {
        $this->mainModel->transaction()->create([
            'wallet_id' => $this->wallet->id, 'type' => $this->type, 'amount' => $this->amount
        ]);
    }
}
