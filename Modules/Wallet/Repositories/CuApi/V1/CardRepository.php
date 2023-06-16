<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Interfaces\CuApi\V1\CardRepositoryInterface;
use Modules\Wallet\Traits\WalletOperationsTrait;

class CardRepository implements CardRepositoryInterface
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
        DB::beginTransaction();
        try {
            $this->makeCard();
            $this->make($this->model, TypeEnum::DEPOSIT->value, $this->model->value);
            DB::commit();
            SendPrivateNotificationJob::dispatch(nCu('wallet', 'title'), nCu('wallet.changes'), sanctum()->id, 'high');
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    protected function makeCard()
    {
        $this->model->update([
            'status' => false
        ]);
    }
}
