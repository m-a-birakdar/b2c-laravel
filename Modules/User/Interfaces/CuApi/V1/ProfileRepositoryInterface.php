<?php

namespace Modules\User\Interfaces\CuApi\V1;

interface ProfileRepositoryInterface
{
    public function update(array $array);
    public function updatePassword(array $array);
}
