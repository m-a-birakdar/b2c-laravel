<?php

namespace Modules\User\Repositories\CoApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\User;
use Modules\User\Interfaces\CoApi\V1\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login(User $user)
    {
        $user->setAttribute('token', $user->createToken($user->phone)->plainTextToken);
        return $user;
    }

    public function logout()
    {
        return sanctum()->tokens()->delete();
    }

    public function existsForLogin($phone)
    {
        return $this->findWhere('phone', $phone, null, ['id', 'name', 'phone', 'password', 'status']);
    }
}
