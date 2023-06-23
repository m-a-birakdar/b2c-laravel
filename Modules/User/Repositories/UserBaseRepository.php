<?php

namespace Modules\User\Repositories;

use App\Repositories\DBTransactionRepository;
use Modules\User\Entities\User;

class UserBaseRepository extends DBTransactionRepository
{
    public User|null $model;

    public function __construct(User $model = new User())
    {
        $this->model = $model;
    }

    public function exists($id): bool
    {
        return $this->model->query()->where('id', $id)->exists();
    }
}
