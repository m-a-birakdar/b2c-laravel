<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\Order\Repositories\Web\OrderRepository;

class NotifyToReviewOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string|int $orderId, $userId;

    public function __construct($orderId, $userId)
    {
        $this->userId = $userId;
        $this->orderId = $orderId;
    }

    public function handle()
    {
        $order = ( new OrderRepository )->hasReview($this->orderId);
        if ($order){
            SendPrivateNotificationJob::dispatch('order', 'review your order', $this->userId, 'low');
            $order->update([
                'notify_review_at' => now()
            ]);
        }
    }
}
