<?php

namespace Modules\Report\Http\Controllers\Web;

use Modules\Report\Http\Requests\Web\ReportRequest;
use Illuminate\Routing\Controller;
use Modules\Report\Interfaces\Web\ReportRepositoryInterface;

class ReportController extends Controller
{
    public ReportRepositoryInterface $repository;

    public function __construct(ReportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('report::index');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('report::create');
    }

    public function store(ReportRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request->validated());
        return back();
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('report::show')->with([
            'report' => $this->repository->show($id)
        ]);
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('report::edit')->with([
            'report' => $this->repository->find($id)
        ]);
    }

    public function update(ReportRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->update($request->validated(), $id);
        return back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->destroy($id);
        return back();
    }
}
