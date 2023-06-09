<?php

namespace Modules\Product\Interfaces\CuApi\V1;

interface ProductRepositoryInterface
{
    public function index($categoryId, $cityId);
    public function show($id, $userId);
    public function related($categoryId, $cityId, $id);
    public function search($cityId, $userId);
}
