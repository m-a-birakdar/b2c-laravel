<?php

namespace Modules\User\Interfaces\CoApi\V1;

use Modules\User\Entities\User;

interface AuthRepositoryInterface
{
    public function login(User $user);
    public function existsForLogin($phone);
}
