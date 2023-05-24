<?php

namespace Modules\Notification\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Interfaces\CuApi\V1\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    use BaseRepositoryTrait;

    public Notification|null $model;

    public function __construct(Notification $model = new Notification())
    {
        $this->model = $model;
    }

    public function index($type = null): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->model->query()->where('user_id', sanctum()->id)->when($type, function ($q) use ($type){
            $q->where('type', $type);
        })->orderByDesc('id')->simplePaginate(null, ['id', 'user_id', 'title', 'body', 'type', 'initial', 'created_at']);
    }

    public function read($id = null): bool|int
    {
        if ($id){
            $this->model = $this->find($id);
            return $this->model->update([
                'read_at' => now()
            ]);
        }
        return $this->model->whereNull('read_at')->where('user_id', sanctum()->id)->update([
            'read_at' => now()
        ]);
    }
}
