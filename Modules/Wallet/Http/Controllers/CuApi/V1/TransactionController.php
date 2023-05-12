<?php

namespace Modules\Wallet\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\Wallet\Http\Requests\CuApi\V1\TransactionRequest;
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

    public function store(TransactionRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->store($request));
    }
}
