<?php

namespace Modules\Notification\Interfaces\CuApi\V1;

interface NotificationRepositoryInterface
{
    public function index($type = null);
    public function read($id = null);
}
