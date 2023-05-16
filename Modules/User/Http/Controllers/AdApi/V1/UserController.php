<?php

namespace Modules\User\Http\Controllers\AdApi\V1;

use Illuminate\Routing\Controller;
use Modules\User\Interfaces\AdApi\V1\UserRepositoryInterface;
use Modules\User\Transformers\AdApi\V1\CouriersResource;

class UserController extends Controller
{
    public UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function couriers(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CouriersResource::collection($this->repository->couriers());
    }
}
