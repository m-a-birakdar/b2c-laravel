<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Currency\Repositories\Web\CurrencyRepository;

class ProductBaseResource extends JsonResource
{
    public static string|int $currency;

    public static function customCollection($resource): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        self::$currency = ( new CurrencyRepository() )->value();
        return parent::collection($resource);
    }
}
