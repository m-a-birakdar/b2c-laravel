<?php

namespace Modules\Order\Observers;

use Modules\Order\Entities\Order;
use Modules\Order\Enums\OrderStatusEnum;

class OrderObserver
{
    public function created(Order $order): void
    {
        $this->insert($order, OrderStatusEnum::Pending->value);
    }

    public function updated(Order $order): void
    {
        $this->insert($order);
    }

    private function insert($order, $status = null): void
    {
        $order->orderStatus()->create([
            'status' => $status ?? $order->status,
            'user_id' => sanctum()->id,
            'created_at' => now()
        ]);
    }
}
