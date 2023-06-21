<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Shipment\Enums\ShipmentStatusEnum;

if (! function_exists('tr'))
{
    function tr($value, $file = 'site.')
    {
        $word = app('translator')->get($file . $value);
        if ($word == $file . $value){
            return str_replace('_',  ' ', ucfirst(last(explode('.', $word))));
        }
        return $word;
    }
}

if (! function_exists('nCu'))
{
    function nCu($value, $type = 'body')
    {
        return tr('notifications.customer.' . $value . '.' . $type);
    }
}

if (! function_exists('nCo'))
{
    function nCo($value, $type = 'body')
    {
        return tr('notifications.courier.' . $value . '.' . $type);
    }
}

if (! function_exists('sanctum'))
{
    function sanctum()
    {
        return app(AuthFactory::class)->guard('sanctum')->user();
    }
}

if (! function_exists('user'))
{
    function user()
    {
        return app(AuthFactory::class)->user();
    }
}

if (! function_exists('all_order_status'))
{
    function all_order_status(): array
    {
        return [
            OrderStatusEnum::Pending->name,
            OrderStatusEnum::Processing->name,
            OrderStatusEnum::Shipment->name,
            OrderStatusEnum::Delivered->name,
        ];
    }
}

if (! function_exists('all_shipment_status'))
{
    function all_shipment_status(): array
    {
        return array_column(ShipmentStatusEnum::cases(), 'name');
    }
}

if (! function_exists('re'))
{
    function re($route, $status, $message, $with = []): RedirectResponse
    {
        return app('redirect')->to($route)->with([$status => $message])->with($with);
    }
}

if (! function_exists('ba'))
{
    function ba($message, $with = [], $status = 'success'): RedirectResponse
    {
        return app('redirect')->back()->with($status, $message)->with($with);
    }
}

if (! function_exists('lo'))
{
    function lo($type, $message, $data = []): void
    {
        Log::{$type}($message, $data);
    }
}

if (! function_exists('th'))
{
    function th($data): void
    {
        throw new HttpResponseException(response()->json([
            'throw' => $data
        ]));
    }
}
