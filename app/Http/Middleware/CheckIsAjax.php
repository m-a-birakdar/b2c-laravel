<?php

namespace App\Http\Middleware;

use App\Http\Resources\MainResource;
use Closure;
use Illuminate\Http\Request;

class CheckIsAjax
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax())
            return $next($request);
        return MainResource::make(null, false, 'This request is not Ajax Request', 422);
    }
}
