<?php

namespace Modules\Product\Interfaces\CuApi\V1;

interface ProductRepositoryInterface
{
    public function index($categoryId, $cityId, $columns = ['*']);
    public function show($id, $userId, $with = null, $columns = ['*']);
}
