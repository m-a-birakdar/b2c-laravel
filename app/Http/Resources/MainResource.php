<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MainResource extends JsonResource
{
    private mixed $message;
    private mixed $success;
    private mixed $statusCode;
    public static $wrap = false;

    public function __construct($resource, $success = true, $message = null, $statusCode = 200) {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->success = $success;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function toArray($request): array
    {
        $data = [
            'success' => (bool) $this->success,
        ];
        if (! is_null($this->message)) $data['message'] = $this->message;
        if (! is_null($this->resource)) $data['data'] = $this->resource;
        return $data;
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
        parent::withResponse($request, $response);
    }
}
