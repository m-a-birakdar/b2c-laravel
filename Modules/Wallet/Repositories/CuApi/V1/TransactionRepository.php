<?php

namespace Modules\Wallet\Repositories\CuApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Entities\Transaction;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Enums\TypeEnum;
use Modules\Wallet\Interfaces\CuApi\V1\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    use BaseRepositoryTrait;

    public Transaction|null $model;

    public function __construct(Transaction $model = new Transaction())
    {
        $this->model = $model;
    }

    public function index()
    {
        $this->wallet = sanctum()->wallet;
        return $this->wallet->transactions()->orderByDesc('id')->simplePaginate();
    }

    private Card $card;
    private Wallet $wallet;

    public function store($request): bool
    {
        DB::beginTransaction();
        $this->card = $request->card;
        try {
            $this->makeWallet();
            $this->makeCard();
            $this->makeTransaction();
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    protected function makeWallet()
    {
        $this->wallet = sanctum()->wallet;
        $this->wallet->update([
            'balance' => $this->wallet->balance + $this->card->value
        ]);
    }

    protected function makeCard()
    {
        $this->card->update([
            'status' => false
        ]);
    }

    protected function makeTransaction()
    {
        $this->card->transaction()->create([
            'wallet_id' => $this->wallet->id, 'type' => TypeEnum::DEPOSIT->value, 'amount' => $this->card->value
        ]);
    }
}
