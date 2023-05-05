<?php

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

if (! function_exists('sanctum'))
{
    function sanctum()
    {
        return app(AuthFactory::class)->guard('sanctum')->user();
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
        return [
            ShipmentStatusEnum::NotYetShipped->name,
            ShipmentStatusEnum::InTransit->name,
            ShipmentStatusEnum::OutForDelivery->name,
            ShipmentStatusEnum::Delivered->name,
            ShipmentStatusEnum::FailedDelivery->name,
            ShipmentStatusEnum::ReturnInProgress->name,
        ];
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

if (! function_exists('write_log'))
{
    function write_log($type, $message, $data = []): void
    {
        Log::{$type}($message, $data);
    }
}
