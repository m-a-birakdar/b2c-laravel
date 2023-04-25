<?php

namespace Modules\Category\Interfaces\Api\V1;

interface CategoryRepositoryInterface
{
    public function main();
    public function sub($categoryId, $columns = ['*']);
}
