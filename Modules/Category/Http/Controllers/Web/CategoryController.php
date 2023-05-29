<?php

namespace Modules\Category\Http\Controllers\Web;

use Modules\Category\DataTable\CategoryDataTable;
use Modules\Category\Http\Requests\Web\CategoryRequest;
use Illuminate\Routing\Controller;
use Modules\Category\Interfaces\Web\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    public CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('datatable', [
            'title' => tr('categories')
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('category::create');
    }

    public function store(CategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request->validated());
        return back();
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('category::show')->with([
            'category' => $this->repository->show($id)
        ]);
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('category::edit')->with([
            'category' => $this->repository->find($id)
        ]);
    }

    public function update(CategoryRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->update($request->validated(), $id);
        return back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        if (! $this->repository->checkBeforeDelete($id)) {
            $this->repository->destroy($id);
            return ba(tr('category_was_deleted_successfully'));
        } else {
            return ba(tr('cant_delete_category'), [], 'error');
        }
    }
}
