<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Interfaces\CuApi\V1\CardRepositoryInterface;
use Modules\Wallet\Traits\WalletOperationsTrait;

class CardRepository extends DBTransactionRepository implements CardRepositoryInterface
{
    use BaseRepositoryTrait, WalletOperationsTrait;

    public Card|null $model;

    public function __construct(Card $model = new Card())
    {
        $this->model = $model;
    }

    public function get($number, $cvv)
    {
        return $this->model->query()->where('number', $number)->where('cvv', $cvv)->where('status', true)->first();
    }

    public function recharge($request): bool
    {
        $this->model = $request->card;
        $this->executeInTransaction(function () {
            $this->makeCard();
            $this->make($this->model, TypeEnum::DEPOSIT->value, $this->model->value);
        });
        SendPrivateNotificationJob::dispatch(nCu('wallet', 'title'), nCu('wallet.changes'), sanctum()->id, 'high');
        return true;
    }

    protected function makeCard()
    {
        $this->model->update([
            'status' => false
        ]);
    }
}
