<?php

namespace App\Traits;

use App\Exceptions\MainException;
use Modules\Category\Repositories\CategoryBaseRepository;
use Modules\City\Repositories\CityBaseRepository;
use Modules\Currency\Repositories\CurrencyBaseRepository;
use Modules\Product\Repositories\ProductBaseRepository;
use Modules\User\Repositories\UserBaseRepository;

trait ModelExistsTrait
{
    public function exists($data): void
    {
        foreach ($data as $key => $datum) {
            $repository = match ($key){
                'category' => new CategoryBaseRepository,
                'city' => new CityBaseRepository,
                'user' => new UserBaseRepository,
                'product' => new ProductBaseRepository,
                'currency' => new CurrencyBaseRepository,
            };
            if (! $repository->exists($datum))
                throw new MainException(false, 'This ' . $key . ' is not exists', 422);
        }
    }

    public function checkParameter($bool): void
    {
        if ($bool)
            throw new MainException(false, 'Check parameter', 422);
    }
}
