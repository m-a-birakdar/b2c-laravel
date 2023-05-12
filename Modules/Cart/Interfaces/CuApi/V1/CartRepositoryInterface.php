<?php

namespace Modules\Cart\Interfaces\CuApi\V1;

interface CartRepositoryInterface
{
    public function index();
    public function checkout();
    public function add($productId);
    public function remove($productId);
}
