<?php

namespace Modules\Category\Interfaces\CuApi\V1;

interface CategoryRepositoryInterface
{
    public function main();
    public function sub($categoryId, $columns = ['*']);
}
