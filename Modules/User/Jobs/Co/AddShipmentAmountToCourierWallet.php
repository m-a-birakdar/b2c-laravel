<?php

namespace Modules\User\Jobs\Co;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\Order;
use Modules\Shipment\Entities\Shipment;
use Modules\User\Entities\User;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Traits\WalletOperationsTrait;

class AddShipmentAmountToCourierWallet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WalletOperationsTrait;

    public int|float|null $value;
    public Shipment $shipment;
    public Wallet $walletModel;

    public function __construct($shipment, $value, $wallet)
    {
        $this->shipment = $shipment;
        $this->value = $value;
        $this->walletModel = $wallet;
        $this->onQueue('low');
    }

    public function handle(): void
    {
        $this->make($this->shipment, TypeEnum::DEPOSIT->value, $this->value, $this->walletModel);
    }
}
