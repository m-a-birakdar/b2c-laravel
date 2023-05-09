<?php

namespace Modules\User\Interfaces\CuApi\V1;

use Modules\User\Entities\User;

interface AuthRepositoryInterface
{
    public function login(User $user);
    public function register($array);
    public function existsForLogin($phone);
}
