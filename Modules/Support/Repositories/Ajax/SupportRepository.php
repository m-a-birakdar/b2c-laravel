<?php

namespace Modules\Support\Repositories\Ajax;

use Modules\Support\Interfaces\Ajax\SupportRepositoryInterface;
use Modules\User\Repositories\Web\UserRepository;

class SupportRepository implements SupportRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function loadUsers(): \Illuminate\Database\Eloquent\Collection|array
    {
        $users = new UserRepository();
        return $users->index();
    }
}
