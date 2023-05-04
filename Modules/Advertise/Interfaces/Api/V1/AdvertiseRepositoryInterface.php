<?php

namespace Modules\Advertise\Interfaces\Api\V1;

interface AdvertiseRepositoryInterface
{
    public function index($type);
    public function one($type);
}
