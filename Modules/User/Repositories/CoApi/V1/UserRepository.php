<?php

namespace Modules\User\Repositories\CoApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\User\Entities\User;
use Modules\User\Interfaces\CoApi\V1\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public function __construct(User $model = new User())
    {
        $this->model = $model;
    }

    public function status($status): bool
    {
        return sanctum()->update([
            'status' => (int) $status
        ]);
    }
}
