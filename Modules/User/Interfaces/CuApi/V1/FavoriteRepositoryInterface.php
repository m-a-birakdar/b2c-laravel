<?php

namespace Modules\User\Interfaces\CuApi\V1;

interface FavoriteRepositoryInterface
{
    public function index();
    public function toggle($status, $id);
}
