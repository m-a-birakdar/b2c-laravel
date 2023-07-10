<?php

namespace Modules\Tag\Http\Controllers\Api\V1;

use Modules\Tag\Http\Requests\Api\V1\TagRequest;
use Illuminate\Routing\Controller;
use Modules\Tag\Interfaces\Api\V1\TagRepositoryInterface;
use Modules\Tag\Transformers\Api\V1\TagResource;

class TagController extends Controller
{
    public TagRepositoryInterface $repository;

    public function __construct(TagRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return TagResource::collection($this->repository->index());
    }

    public function store(TagRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): TagResource
    {
        return TagResource::make($this->repository->show($id));
    }

    public function update(TagRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
