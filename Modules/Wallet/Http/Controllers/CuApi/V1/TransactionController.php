<?php

namespace Modules\Wallet\Http\Controllers\CuApi\V1;

use Illuminate\Routing\Controller;
use Modules\Wallet\Interfaces\CuApi\V1\TransactionRepositoryInterface;
use Modules\Wallet\Transformers\CuApi\V1\TransactionResource;

class TransactionController extends Controller
{
    public TransactionRepositoryInterface $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return TransactionResource::collection($this->repository->index());
    }
}
