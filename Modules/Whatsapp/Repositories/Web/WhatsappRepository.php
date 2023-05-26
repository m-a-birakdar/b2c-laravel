<?php

namespace Modules\Whatsapp\Repositories\Web;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Whatsapp\Interfaces\Web\WhatsappRepositoryInterface;
use Modules\Whatsapp\Entities\Whatsapp;

class WhatsappRepository implements WhatsappRepositoryInterface
{
    use BaseRepositoryTrait;

    public Whatsapp|null $model;

    public function __construct(Whatsapp $model = new Whatsapp())
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
