<?php

namespace Modules\Wallet\Http\Controllers\Api\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Wallet\Http\Requests\Api\V1\TransactionRequest;
use Modules\Wallet\Interfaces\Api\V1\TransactionRepositoryInterface;
use Modules\Wallet\Transformers\Api\V1\TransactionResource;

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

    public function store(TransactionRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->store($request));
    }
}
