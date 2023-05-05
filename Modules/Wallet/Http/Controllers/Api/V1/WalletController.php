<?php

namespace Modules\Wallet\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Modules\Wallet\Interfaces\Api\V1\WalletRepositoryInterface;
use Modules\Wallet\Transformers\Api\V1\WalletResource;

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
