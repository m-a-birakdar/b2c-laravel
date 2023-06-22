<?php

namespace Modules\Wallet\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Wallet\Http\Requests\CuApi\V1\SendRequest;
use Modules\Wallet\Interfaces\CuApi\V1\WalletRepositoryInterface;
use Modules\Wallet\Transformers\CuApi\V1\WalletResource;

class WalletController extends Controller
{
    public WalletRepositoryInterface $repository;

    public function __construct(WalletRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show(): WalletResource
    {
        return WalletResource::make($this->repository->show());
    }

    public function send(SendRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->send($request));
    }
}
