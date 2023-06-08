<?php

namespace Modules\Report\Http\Controllers\DaApi;

use App\Exceptions\DashboardApiException;
use Illuminate\Http\Request;
use Modules\Report\Interfaces\DaApi\MainReportRepositoryInterface;

class MainReportController extends ValidateMethodsController
{
    public MainReportRepositoryInterface $repository;

    public function __construct(MainReportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        $this->validate();
        return $this->repository->show($request->input('type'), $this->values);
    }

    public function index(Request $request)
    {
        $this->validate();
        return $this->repository->index($request->input('type'), $request->input('sub'));
    }

    private function validate()
    {
        if ($this->validateRouteMethodMain())
            throw new DashboardApiException();
    }
}
