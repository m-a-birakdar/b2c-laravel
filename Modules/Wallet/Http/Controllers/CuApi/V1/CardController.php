<?php

namespace Modules\Wallet\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Wallet\Http\Requests\CuApi\V1\RechargeCardRequest;
use Modules\Wallet\Interfaces\CuApi\V1\CardRepositoryInterface;

class CardController extends Controller
{
    public CardRepositoryInterface $repository;

    public function __construct(CardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function recharge(RechargeCardRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->recharge($request));
    }
}
