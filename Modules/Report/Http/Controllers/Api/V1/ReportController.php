<?php

namespace Modules\Report\Http\Controllers\Api\V1;

use Modules\Report\Http\Requests\Api\V1\ReportRequest;
use Illuminate\Routing\Controller;
use Modules\Report\Interfaces\Api\V1\ReportRepositoryInterface;
use Modules\Report\Transformers\Api\V1\ReportResource;

class ReportController extends Controller
{
    public ReportRepositoryInterface $repository;

    public function __construct(ReportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ReportResource::collection($this->repository->index());
    }

    public function store(ReportRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): ReportResource
    {
        return ReportResource::make($this->repository->show($id));
    }

    public function update(ReportRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
