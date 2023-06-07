<?php

namespace App\Exceptions;

use App\Http\Resources\MainResource;
use Exception;

class DashboardApiException extends Exception
{
    public function render(): MainResource
    {
        return MainResource::make(null, false, 'Some things wrong', 404);
    }
}
