<?php

namespace Modules\Advertise\Interfaces\CuApi\V1;

interface AdvertiseRepositoryInterface
{
    public function index($type, $user);
    public function one($type, $user);
    public function click($id, $user);
    public function view($id, $user);
}
