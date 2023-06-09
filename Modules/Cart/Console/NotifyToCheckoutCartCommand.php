<?php

namespace Modules\Cart\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Cart\Entities\Cart;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Symfony\Component\Console\Command\Command as CommandAlias;

class NotifyToCheckoutCartCommand extends Command
{
    protected $name = 'cart:notify';

    protected $description = 'Notify to checkout cart command.';

    public function handle()
    {
        Cart::query()->with(['user:id', 'user.details:user_id,fcm_token'])->whereNull('notify_at')->orWhere('notify_at', '<', Carbon::now()->subDays(2))
            ->select(['id', 'user_id', 'notify_at'])->chunkById(100, function ($carts){
            foreach ($carts as $cart) {
                SendPrivateNotificationJob::dispatch('cart', 'checkout your cart', $cart->user, 'low');
                $cart->update([
                    'notify_at' => now()
                ]);
            }
        });
        echo CommandAlias::SUCCESS;
    }
}
