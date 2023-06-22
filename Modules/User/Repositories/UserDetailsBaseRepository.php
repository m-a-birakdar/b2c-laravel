<?php

namespace Modules\User\Repositories;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\User\Entities\UserDetails;

class UserDetailsBaseRepository
{
    use BaseRepositoryTrait;

    public UserDetails|null $model;

    public function __construct(UserDetails $model = new UserDetails())
    {
        $this->model = $model;
    }

    public function update($userId, $array): bool
    {
        $this->findWhere('user_id', $userId);
        return $this->model->update($array);
    }
}
