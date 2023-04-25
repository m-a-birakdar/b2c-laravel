<?php

namespace App\Http\Middleware;

use App\Http\Resources\MainResource;
use Closure;
use Illuminate\Http\Request;

class CheckApiIsJson
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->wantsJson())
            return $next($request);
        return MainResource::make(null, false, 'This request is not Api Request', 422);
    }
}
