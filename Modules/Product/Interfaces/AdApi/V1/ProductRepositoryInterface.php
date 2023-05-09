<?php

namespace Modules\Product\Interfaces\AdApi\V1;

interface ProductRepositoryInterface
{
    public function index($categoryId, $cityId, $columns = ['*']);
    public function show($id, $with = null, $columns = ['*']);
    public function update($array, $id);
}
