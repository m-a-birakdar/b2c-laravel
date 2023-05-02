<?php

namespace Modules\Support\Http\Controllers\Api\V1;

use Modules\Support\Http\Requests\Api\V1\SupportRequest;
use Illuminate\Routing\Controller;
use Modules\Support\Interfaces\Api\V1\SupportRepositoryInterface;
use Modules\Support\Transformers\Api\V1\SupportResource;

class SupportController extends Controller
{
    public SupportRepositoryInterface $repository;

    public function __construct(SupportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SupportResource::collection($this->repository->index());
    }

    public function store(SupportRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): SupportResource
    {
        return SupportResource::make($this->repository->show($id));
    }

    public function update(SupportRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
