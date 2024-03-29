<?php

namespace Modules\Report\Http\Controllers\DaApi;

use App\Exceptions\DashboardApiException;
use Illuminate\Http\Request;
use Modules\Product\Repositories\Web\ProductRepository;
use Modules\Report\Interfaces\DaApi\ProductReportRepositoryInterface;

class ProductReportController extends ValidateMethodsController
{
    public ProductReportRepositoryInterface $repository;

    public function __construct(ProductReportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        $this->validate();
        return $this->repository->show($request->input('product_id'), $request->input('type'), $this->values);
    }

    public function compareOne(Request $request)
    {
        $this->validate();
        return $this->repository->compareOne($this->toArray($request), $request->input('type'), $this->values);
    }

    public function index(Request $request)
    {
        $this->validate();
        return $this->repository->index($request->input('product_id'), $request->input('type'), $request->input('sub'));
    }

    public function compareMany(Request $request)
    {
        $this->validate();
        return $this->repository->compareMany($this->toArray($request), $request->input('type'), $request->input('sub'));
    }

    private function toArray($request): array
    {
        return explode(',', $request->input('product_id'));
    }

    private function validate()
    {
        if ($this->validateRouteMethod('product', new ProductRepository()))
            throw new DashboardApiException();
    }
}
