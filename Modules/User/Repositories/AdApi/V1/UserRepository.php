<?php

namespace Modules\User\Repositories\AdApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\User\Entities\User;
use Modules\User\Interfaces\AdApi\V1\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public function __construct(User $model = new User())
    {
        $this->model = $model;
    }

    public function couriers()
    {
        return $this->model->whereHas('roles', function ($query)  {
            $query->where('name', 'admin');
        })->available()->get();
    }
}
