<?php

namespace Modules\Invoice\Http\Controllers\Api\V1;

use Modules\Invoice\Http\Requests\Api\V1\InvoiceRequest;
use Illuminate\Routing\Controller;
use Modules\Invoice\Interfaces\Api\V1\InvoiceRepositoryInterface;
use Modules\Invoice\Transformers\Api\V1\InvoiceResource;

class InvoiceController extends Controller
{
    public InvoiceRepositoryInterface $repository;

    public function __construct(InvoiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return InvoiceResource::collection($this->repository->index());
    }

    public function store(InvoiceRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    public function show($id): InvoiceResource
    {
        return InvoiceResource::make($this->repository->show($id));
    }

    public function update(InvoiceRequest $request, $id)
    {
        return $this->repository->update($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
