<?php

namespace Modules\Coupon\Console;

use Illuminate\Console\Command;
use Modules\Notification\Jobs\SendPrivateNotificationJob;
use Modules\User\Entities\User;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotifyToNewCouponCommand extends Command
{
    protected $name = 'coupon:notify';

    protected $description = 'Notify to new coupon command.';

    public function handle(): int
    {
        User::query()->with('details:user_id,fcm_token')->available()->select(['id'])->chunkById(10, function ($users){
            foreach ($users as $user) {
                SendPrivateNotificationJob::dispatch('coupon', 'new coupon', $user, 'low');
            }
        });
        return CommandAlias::SUCCESS;
    }
}
