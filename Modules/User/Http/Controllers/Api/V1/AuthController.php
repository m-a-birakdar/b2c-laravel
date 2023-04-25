<?php

namespace Modules\User\Http\Controllers\Api\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\Api\V1\LoginRequest;
use Modules\User\Http\Requests\Api\V1\RegisterRequest;
use Modules\User\Interfaces\Api\V1\AuthRepositoryInterface;
use Modules\User\Transformers\Api\V1\AuthResource;

class AuthController extends Controller
{
    public AuthRepositoryInterface $repository;

    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login(LoginRequest $request): AuthResource
    {
        return AuthResource::make($this->repository->login($request->user, $request->validated()));
    }

    public function register(RegisterRequest $request): AuthResource
    {
        return AuthResource::make($this->repository->register($request->validated()));
    }

    public function logout(): MainResource
    {
        return MainResource::make(null, (bool) $this->repository->logout());
    }

}
