<?php

namespace Modules\Wallet\Http\Controllers\CuApi\V1;

use Illuminate\Routing\Controller;
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
}
