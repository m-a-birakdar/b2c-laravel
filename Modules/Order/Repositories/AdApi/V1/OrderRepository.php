<?php

namespace Modules\Order\Repositories\AdApi\V1;

use App\Exceptions\ApiErrorException;
use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Order\Entities\Order;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Interfaces\AdApi\V1\OrderRepositoryInterface;
use Modules\User\Repositories\Web\UserRepository;

class OrderRepository implements OrderRepositoryInterface
{
    use BaseRepositoryTrait;

    public Order|null $model;

    public function __construct(Order $model = new Order())
    {
        $this->model = $model;
    }

    public function index($status): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->with([
            'user:id,name,phone', 'address:id,address'
        ])->get(['id', 'user_id', 'address_id', 'status', 'total_amount', 'created_at']);
    }

    public function show($id)
    {
        return $this->findWhere('id', $id, [
            'user:id,name,phone', 'address:id,address', 'products:id,thumbnail,title'
        ]);
    }

    public function toProcessing($id): bool|int
    {
//        $this->model = $this->find($id, null, ['id', 'status', 'user_id']);
//        $this->model->update([
//            'status' => OrderStatusEnum::Processing
//        ]);
        SendPrivateNotificationJob::dispatch('title', 'body', 5, 'high');
         return true;
    }

    public function toShipment($array): bool|int
    {
        $this->model = $this->findWhere('id', $array['order_id'], [], ['id', 'status', 'user_id', 'address_id']);
        DB::beginTransaction();
        try {
            $this->setShipment($array['courier_id']);
            $this->model->update([
                'status' => OrderStatusEnum::Shipment
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e){
            throw new ApiErrorException($e);
        }
    }

    public function setShipment($courierId)
    {
        $this->model->shipment()->create([
            'track_number' => mt_rand(1000000000, 9999999999),
            'customer_id' => $this->model->user_id,
            'courier_id' => $courierId,
            'address_id' => $this->model->address_id,
        ]);
    }
}
