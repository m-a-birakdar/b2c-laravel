<?php

namespace Modules\User\Interfaces\AdApi\V1;

use Modules\User\Entities\User;

interface AuthRepositoryInterface
{
    public function login(User $user);
    public function existsForLogin($phone);
    public function logout();
}
