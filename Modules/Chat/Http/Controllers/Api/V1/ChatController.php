<?php

namespace Modules\Chat\Http\Controllers\Api\V1;

use Modules\Chat\Http\Requests\Api\V1\ChatRequest;
use Illuminate\Routing\Controller;
use Modules\Chat\Interfaces\Api\V1\ChatRepositoryInterface;
use Modules\Chat\Transformers\Api\V1\ChatResource;

class ChatController extends Controller
{
    public ChatRepositoryInterface $repository;

    public function __construct(ChatRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ChatResource::collection($this->repository->index());
    }

    public function store(ChatRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): ChatResource
    {
        return ChatResource::make($this->repository->show($id));
    }

    public function update(ChatRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
