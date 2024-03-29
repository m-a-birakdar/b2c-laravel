<?php

namespace Modules\User\Http\Controllers\CoApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CoApi\V1\LoginRequest;
use Modules\User\Interfaces\CoApi\V1\AuthRepositoryInterface;
use Modules\User\Transformers\CoApi\V1\AuthResource;

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

    public function logout(): MainResource
    {
        return MainResource::make(null, (bool) $this->repository->logout());
    }
}
