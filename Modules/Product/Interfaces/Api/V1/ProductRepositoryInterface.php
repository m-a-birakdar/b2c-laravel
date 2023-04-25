<?php

namespace Modules\Product\Interfaces\Api\V1;

interface ProductRepositoryInterface
{
    public function index($categoryId, $columns = ['*']);
    public function show($id, $with = null, $columns = ['*']);
}
