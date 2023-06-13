<?php

namespace Modules\Chat\Http\Controllers\Ajax;

use Illuminate\Routing\Controller;
use Modules\Chat\Interfaces\Ajax\ChatRepositoryInterface;
use Modules\Chat\Transformers\Ajax\ChatResource;
use Modules\User\Repositories\Web\UserRepository;

class ChatController extends Controller
{
    public ChatRepositoryInterface $repository;

    public function __construct(ChatRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function loadUsers()
    {
        return ( new UserRepository )->loadUsersForChat();
    }

    public function messages(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ChatResource::collection($this->repository->messages(request('first_id'), request('second_id')));
    }
}
