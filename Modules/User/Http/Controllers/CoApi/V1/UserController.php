<?php

namespace Modules\User\Http\Controllers\CoApi\V1;

use App\Http\Resources\MainResource;
use Illuminate\Routing\Controller;
use Modules\User\Interfaces\CoApi\V1\UserRepositoryInterface;

class UserController extends Controller
{
    public UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function status($status): MainResource
    {
        return MainResource::make(null, $this->repository->status($status));
    }
}
