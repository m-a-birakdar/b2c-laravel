<?php

namespace Modules\Tenant\Http\Controllers\Api\V1;

use Modules\Tenant\Http\Requests\Api\V1\TenantRequest;
use Illuminate\Routing\Controller;
use Modules\Tenant\Interfaces\Api\V1\TenantRepositoryInterface;
use Modules\Tenant\Transformers\Api\V1\TenantResource;

class TenantController extends Controller
{
    public TenantRepositoryInterface $repository;

    public function __construct(TenantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return TenantResource::collection($this->repository->index());
    }

    public function store(TenantRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): TenantResource
    {
        return TenantResource::make($this->repository->show($id));
    }

    public function update(TenantRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
