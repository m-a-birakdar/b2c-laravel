<?php

namespace Modules\Wallet\Http\Controllers\Web;

use Modules\Wallet\Http\Requests\Web\WalletRequest;
use Illuminate\Routing\Controller;
use Modules\Wallet\Interfaces\Web\WalletRepositoryInterface;

class WalletController extends Controller
{
    public WalletRepositoryInterface $repository;

    public function __construct(WalletRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('wallet::index');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('wallet::create');
    }

    public function store(WalletRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request->validated());
        return back();
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('wallet::show')->with([
            'wallet' => $this->repository->show($id)
        ]);
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('wallet::edit')->with([
            'wallet' => $this->repository->find($id)
        ]);
    }

    public function update(WalletRequest $request, $id): \Illuminate\Http\RedirectResponse
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
