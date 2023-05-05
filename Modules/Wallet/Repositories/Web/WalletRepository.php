<?php

namespace Modules\Wallet\Repositories\Web;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Wallet\Interfaces\Web\WalletRepositoryInterface;
use Modules\Wallet\Entities\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    use BaseRepositoryTrait;

    public Wallet|null $model;

    public function __construct(Wallet $model)
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
}
