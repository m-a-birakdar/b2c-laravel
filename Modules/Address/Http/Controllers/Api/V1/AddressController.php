<?php

namespace Modules\Address\Http\Controllers\Api\V1;

use App\Http\Resources\MainResource;
use Modules\Address\Http\Requests\Api\V1\AddressRequest;
use Illuminate\Routing\Controller;
use Modules\Address\Interfaces\Api\V1\AddressRepositoryInterface;
use Modules\Address\Transformers\Api\V1\AddressResource;

class AddressController extends Controller
{
    public AddressRepositoryInterface $repository;

    public function __construct(AddressRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return AddressResource::collection($this->repository->index());
    }

    public function store(AddressRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->store($request->validated()));
    }

    public function show($id): AddressResource
    {
        return AddressResource::make($this->repository->show($id));
    }

    public function update(AddressRequest $request, $id): MainResource
    {
        return MainResource::make(null, $this->repository->update($request->validated(), $id));
    }

    public function destroy($id): MainResource
    {
        return MainResource::make(null, $this->repository->destroy($id));
    }
}
