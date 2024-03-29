<?php

namespace Modules\User\Repositories\Web;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\User\Interfaces\Web\UserRepositoryInterface;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    use BaseRepositoryTrait;

    public User|null $model;

    public function __construct(User $model = new User())
    {
        $this->model = $model;
    }

    public function index($columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->get();
    }

    public function store(array $array): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->query()->create($array);
    }

    public function show($id, $with = null, $columns = ['*'])
    {
        // TODO: Implement show() method.
    }

    public function update(array $array, $id): int
    {
        return $this->model->query()->where('id', $id)->update($array);
    }

    public function destroy($id)
    {
        return $this->model->query()->where('id', $id)->delete();
    }

    public function roles($rule = 'manager')
    {
        return Role::query()->where('name', '!=', 'customer')->when($rule == 'admin', function ($q){
            $q->where('name', '!=', 'manager');
        })->get();
    }

    public function loadUsersForChat()
    {
        return $this->model->query()->where('id', '!=', auth()->id())->simplePaginate();
    }
}
