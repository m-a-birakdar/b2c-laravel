<?php

namespace Modules\Shipment\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Order\Repositories\CuApi\V1\OrderRepository;
use Modules\Shipment\Interfaces\CuApi\V1\ShipmentRepositoryInterface;
use Modules\Shipment\Entities\Shipment;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    use BaseRepositoryTrait;

    public Shipment|null $model;

    public function __construct(Shipment $model = new Shipment())
    {
        $this->model = $model;
    }

    public function show($orderId): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        $order = ( new OrderRepository() )->find($orderId);
        $shipmentId = $order->shipment->id;
        return $this->find($shipmentId, ['address', 'customer']);
    }
}
