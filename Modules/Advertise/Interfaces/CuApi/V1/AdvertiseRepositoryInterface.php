<?php

namespace Modules\Advertise\Interfaces\CuApi\V1;

interface AdvertiseRepositoryInterface
{
    public function index($type);
    public function one($type);
    public function click($id);
}
