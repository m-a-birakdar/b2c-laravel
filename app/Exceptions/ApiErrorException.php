<?php

namespace App\Exceptions;

use App\Http\Resources\MainResource;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiErrorException extends Exception
{
    private Exception $exception;
    private bool $rollBack;

    public function __construct(Exception $exception, bool $rollBack = true)
    {
        parent::__construct();
        $this->exception = $exception;
        $this->rollBack = $rollBack;
    }

    public function render(): MainResource
    {
        if ($this->rollBack) DB::rollBack();
        Log::error($this->exception->getMessage(), [$this->exception]);
        return MainResource::make(null, false, 'Some thing wrong', 500);
    }
}
