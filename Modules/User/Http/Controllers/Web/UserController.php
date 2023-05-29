<?php

namespace Modules\User\Http\Controllers\Web;

use Modules\User\DataTable\UserDataTable;
use Modules\User\Http\Requests\Web\UserRequest;
use Illuminate\Routing\Controller;
use Modules\User\Interfaces\Web\UserRepositoryInterface;
use Modules\User\Repositories\Web\UserRepository;

class UserController extends Controller
{
    public UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('datatable', [
            'title' => tr('users')
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('user::create')->with([
            'roles' => ( new UserRepository() )->roles(user()->hasRole('admin') ? 'admin' : 'manager'),
        ]);
    }

    public function store(UserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request->validated());
        return back();
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('user::show')->with([
            'user' => $this->repository->show($id)
        ]);
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('user::edit')->with([
            'user' => $this->repository->find($id)
        ]);
    }

    public function update(UserRequest $request, $id): \Illuminate\Http\RedirectResponse
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
