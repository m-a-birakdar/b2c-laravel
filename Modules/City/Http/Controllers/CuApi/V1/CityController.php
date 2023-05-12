<?php

namespace Modules\City\Http\Controllers\CuApi\V1;

use Modules\City\Http\Requests\CuApi\V1\CityRequest;
use Illuminate\Routing\Controller;
use Modules\City\Interfaces\CuApi\V1\CityRepositoryInterface;
use Modules\City\Transformers\CuApi\V1\CityResource;

class CityController extends Controller
{
    public CityRepositoryInterface $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CityResource::collection($this->repository->index());
    }

    public function store(CityRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): CityResource
    {
        return CityResource::make($this->repository->show($id));
    }

    public function update(CityRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
