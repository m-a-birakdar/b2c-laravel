<?php

namespace Modules\Product\Interfaces\AdApi\V1;

interface ProductRepositoryInterface
{
    public function index($categoryId);
    public function show($id);
    public function search($text);
    public function update($array, $id);
}
