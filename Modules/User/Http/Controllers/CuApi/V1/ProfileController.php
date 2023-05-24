<?php

namespace Modules\User\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CuApi\V1\UpdatePasswordRequest;
use Modules\User\Http\Requests\CuApi\V1\UpdateProfileRequest;
use Modules\User\Interfaces\CuApi\V1\ProfileRepositoryInterface;

class ProfileController extends Controller
{
    public ProfileRepositoryInterface $repository;

    public function __construct(ProfileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(UpdateProfileRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->update($request->validated()));
    }

    public function updatePassword(UpdatePasswordRequest $request): MainResource
    {
        return MainResource::make(null, $this->repository->updatePassword($request->validated()));
    }
}
