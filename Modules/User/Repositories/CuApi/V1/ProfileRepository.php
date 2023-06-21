<?php

namespace Modules\User\Repositories\CuApi\V1;

use App\Repositories\DBTransactionRepository;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\User\Entities\User;
use Modules\User\Interfaces\CuApi\V1\ProfileRepositoryInterface;

class ProfileRepository extends DBTransactionRepository implements ProfileRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public function __construct(User $model = new User())
    {
        $this->model = $model;
    }

    public function update(array $array): bool
    {
        $this->model = ( new UserRepository() )->find(sanctum()->id, 'details');
        return $this->executeInTransaction(function () use ($array) {
            $this->model->update([
                'email' => $array['email']
            ]);
            // Todo update image
            if (array_key_exists('email', $array))
                $array['email_verified_at'] = null;
            unset($array['email']);
            $this->model->details()->update($array);
            return true;
        });
    }

    public function updatePassword(array $array): bool|int
    {
        $this->model = ( new UserRepository() )->find(sanctum()->id, null, ['id', 'password']);
        return $this->model->update([
            'password' => bcrypt($array['password'])
        ]);
    }
}
