<?php

namespace Modules\User\Http\Controllers\CuApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CuApi\V1\LoginRequest;
use Modules\User\Http\Requests\CuApi\V1\RegisterRequest;
use Modules\User\Http\Requests\CuApi\V1\SendOTPRequest;
use Modules\User\Http\Requests\CuApi\V1\VerifyEmailRequest;
use Modules\User\Http\Requests\CuApi\V1\VerifyOTPRequest;
use Modules\User\Interfaces\CuApi\V1\AuthRepositoryInterface;
use Modules\User\Transformers\CuApi\V1\AuthResource;

class AuthController extends Controller
{
    public AuthRepositoryInterface $repository;

    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login(LoginRequest $request): AuthResource
    {
        return AuthResource::make($this->repository->login($request->user));
    }

    public function register(RegisterRequest $request): AuthResource
    {
        return AuthResource::make($this->repository->register($request->validated()));
    }

    public function logout(): MainResource
    {
        return MainResource::make(null, (bool) $this->repository->logout());
    }

    public function sendOtp(SendOTPRequest $request): MainResource
    {
        return MainResource::make(null, (bool) $this->repository->sendOtp($request->validated()));
    }

    public function verifyOtp(VerifyOTPRequest $request): MainResource
    {
        return MainResource::make(null, (bool) $this->repository->verifyOtp($request->validated()));
    }

    public function verifyEmail(VerifyEmailRequest $request): MainResource
    {
        return MainResource::make(null, (bool) $this->repository->verifyEmail($request->validated()));
    }

    public function verifyEmailToken(VerifyEmailRequest $request): MainResource
    {
        return MainResource::make(null, (bool) $this->repository->verifyEmailToken($request->validated()));
    }

}
