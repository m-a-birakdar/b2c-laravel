<?php

namespace Modules\Chat\Repositories\Ajax;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Chat\Interfaces\Ajax\ChatRepositoryInterface;
use Modules\Chat\Entities\Chat;

class ChatRepository implements ChatRepositoryInterface
{
    use BaseRepositoryTrait;

    public Chat|null $model;

    public function __construct(Chat $model)
    {
        $this->model = $model;
    }

    public function messages( $firstId, $secondId)
    {
        return $this->model->query()->where(function ($q) use ($firstId, $secondId){
            $q->where('sender_id', (int) $firstId)->where('receipt_id', (int) $secondId);
        })->orWhere(function ($q) use ($firstId, $secondId){
            $q->where('receipt_id', (int) $firstId)->where('sender_id', (int) $secondId);
        })->orderByDesc('created_at')->simplePaginate();
    }
}
