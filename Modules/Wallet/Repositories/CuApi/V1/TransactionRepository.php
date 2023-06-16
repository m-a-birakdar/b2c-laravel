<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Entities\Transaction;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Interfaces\CuApi\V1\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    use BaseRepositoryTrait;

    public Transaction|null $model;
    public Wallet $wallet;

    public function __construct(Transaction $model = new Transaction())
    {
        $this->model = $model;
    }

    public function index()
    {
        $this->wallet = ( new WalletRepository() )->show();
        return $this->wallet->transactions()->orderByDesc('id')->simplePaginate();
    }
}
