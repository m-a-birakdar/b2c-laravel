<?php

namespace Modules\Shipment\Repositories\CoApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Order\Repositories\CoApi\V1\OrderRepository;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\Shipment\Interfaces\CoApi\V1\ShipmentRepositoryInterface;
use Modules\Shipment\Entities\Shipment;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    use BaseRepositoryTrait;

    public Shipment|null $model;

    public function __construct(Shipment $model = new Shipment())
    {
        $this->model = $model;
    }

    public function show($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->find($id, ['address:id,address', 'customer:id,name', 'order:id,sku,payment_method,items_count,items_qty']);
    }

    public function index($status)
    {
        match ($status){
             'now' => $s = [ShipmentStatusEnum::NotYetShipped->value, ShipmentStatusEnum::InTransit->value, ShipmentStatusEnum::OutForDelivery->value],
             'delivered' => $s = [ShipmentStatusEnum::Delivered->value],
        };
        return $this->model->query()->whereIntegerInRaw('status', $s)->where('courier_id', sanctum()->id)->simplePaginate();
    }
}
