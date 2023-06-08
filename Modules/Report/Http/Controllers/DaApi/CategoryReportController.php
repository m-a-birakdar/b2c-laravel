<?php

namespace Modules\Report\Http\Controllers\DaApi;

use App\Exceptions\DashboardApiException;
use Illuminate\Http\Request;
use Modules\Category\Repositories\Web\CategoryRepository;
use Modules\Report\Interfaces\DaApi\CategoryReportRepositoryInterface;

class CategoryReportController extends ValidateMethodsController
{
    public CategoryReportRepositoryInterface $repository;

    public function __construct(CategoryReportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        $this->validate();
        return $this->repository->show($request->input('category_id'), $request->input('type'), $this->values);
    }

    public function compareOne(Request $request)
    {
        $this->validate();
        return $this->repository->compareOne($this->toArray($request), $request->input('type'), $this->values);
    }

    public function index(Request $request)
    {
        $this->validate();
        return $this->repository->index($request->input('category_id'), $request->input('type'), $request->input('sub'));
    }

    public function compareMany(Request $request)
    {
        $this->validate();
        return $this->repository->compareMany($this->toArray($request), $request->input('type'), $request->input('sub'));
    }

    private function toArray($request): array
    {
        return explode(',', $request->input('category_id'));
    }

    private function validate()
    {
        if ($this->validateRouteMethod('category', new CategoryRepository()))
            throw new DashboardApiException();
    }
}
