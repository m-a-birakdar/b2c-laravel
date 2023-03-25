<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

if (! function_exists('tr'))
{
    function tr($value)
    {
        return app('translator')->get('site.' . $value);
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
