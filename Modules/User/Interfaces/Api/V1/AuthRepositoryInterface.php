<?php

namespace Modules\User\Interfaces\Api\V1;

use Modules\User\Entities\User;

interface AuthRepositoryInterface
{
    public function login(User $user, $array);
    public function register($array);
    public function existsForLogin($phone);
}
