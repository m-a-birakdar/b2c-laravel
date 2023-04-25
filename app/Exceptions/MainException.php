<?php

namespace App\Exceptions;

use App\Http\Resources\MainResource;
use Exception;

class MainException extends Exception
{
    private string $text;
    private bool $success;
    private int $statusCode;

    public function __construct(bool $success, string $text, int $statusCode)
    {
        $this->text = $text;
        $this->success = $success;
        $this->statusCode = $statusCode;
    }

    public function render(): MainResource
    {
        return MainResource::make(null, $this->success, $this->text, $this->statusCode);
    }
}
