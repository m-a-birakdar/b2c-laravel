<?php

namespace Modules\Support\Http\Controllers\Ajax;

use Illuminate\Routing\Controller;
use Modules\Support\Interfaces\Ajax\SupportRepositoryInterface;

class SupportController extends Controller
{
    public SupportRepositoryInterface $repository;

    public function __construct(SupportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function loadUsers()
    {
        return $this->repository->loadUsers();
    }
}
