<?php

namespace Modules\Product\Console;

use Illuminate\Console\Command;
use Modules\City\Entities\City;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DiscountProductsNotifyCommand extends Command
{
    protected $name = 'product:discount-notify';

    protected $description = 'Discount products notify command.';

    public function handle(): int
    {
        $products = Product::query()->orderByDesc('discount')->limit(10)->get(['id', 'title', 'thumbnail', 'price', 'discount'])->toArray();
        User::query()->select(['id', 'email'])->chunkById(100, function ($users){
            foreach ($users as $user) {
                dd($user->toArray());
            }
        });
        return CommandAlias::SUCCESS;
    }
}
