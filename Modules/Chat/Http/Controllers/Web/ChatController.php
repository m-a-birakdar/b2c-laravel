<?php

namespace Modules\Chat\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Modules\Chat\Interfaces\Web\ChatRepositoryInterface;

class ChatController extends Controller
{
    public ChatRepositoryInterface $repository;

    public function __construct(ChatRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('chat::index');
    }
}
