<?php

namespace Modules\Cart\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Jobs\AbandonedCartRecoveryJob;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Symfony\Component\Console\Command\Command as CommandAlias;

class AbandonedCartRecoveryCommand extends Command
{
    protected $name = 'cart:abandoned-notify';

    protected $description = 'Abandoned cart recovery command.';

    public function handle()
    {
        Cart::query()->with(['user:id,email', 'user.details:user_id,fcm_token', 'products:id,title,thumbnail,price,discount'])->whereNull('notify_at')->orWhere('notify_at', '<', Carbon::now()->subDays(2))
            ->select(['id', 'user_id', 'notify_at'])->chunkById(100, function ($carts){
                foreach ($carts as $cart) {
                    if ($cart->user->email)
                        AbandonedCartRecoveryJob::dispatch($cart->user->email, $cart->products->toArray());
                    SendPrivateNotificationJob::dispatch('cart', 'checkout your cart', $cart->user, 'low');
                    $cart->update([
                        'notify_at' => now()
                    ]);
                }
            });
        echo CommandAlias::SUCCESS;
    }
}
