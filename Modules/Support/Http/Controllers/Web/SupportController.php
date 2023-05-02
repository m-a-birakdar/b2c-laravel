<?php

namespace Modules\Support\Http\Controllers\Web;

use Modules\Support\Http\Requests\Web\SupportRequest;
use Illuminate\Routing\Controller;
use Modules\Support\Interfaces\Web\SupportRepositoryInterface;

class SupportController extends Controller
{
    public SupportRepositoryInterface $repository;

    public function __construct(SupportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('support::index');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('support::create');
    }

    public function store(SupportRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request->validated());
        return back();
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('support::show')->with([
            'support' => $this->repository->show($id)
        ]);
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('support::edit')->with([
            'support' => $this->repository->find($id)
        ]);
    }

    public function update(SupportRequest $request, $id): \Illuminate\Http\RedirectResponse
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
