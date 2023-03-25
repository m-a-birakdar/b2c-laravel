<?php

namespace Modules\Currency\Http\Controllers\Api\V1;

use Modules\Currency\Http\Requests\Api\V1\CurrencyRequest;
use Illuminate\Routing\Controller;
use Modules\Currency\Interfaces\Api\V1\CurrencyRepositoryInterface;
use Modules\Currency\Transformers\Api\V1\CurrencyResource;

class CurrencyController extends Controller
{
    public CurrencyRepositoryInterface $repository;

    public function __construct(CurrencyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->index());
    }

    public function store(CurrencyRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): UserResource
    {
        return UserResource::make($this->repository->show($id));
    }

    public function update(CurrencyRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
