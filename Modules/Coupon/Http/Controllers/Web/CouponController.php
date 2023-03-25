<?php

namespace Modules\Coupon\Http\Controllers\Web;

use Modules\Coupon\Http\Requests\Web\CouponRequest;
use Illuminate\Routing\Controller;
use Modules\Coupon\Interfaces\Web\CouponRepositoryInterface;

class CouponController extends Controller
{
    public CouponRepositoryInterface $repository;

    public function __construct(CouponRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('coupon::index');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('coupon::create');
    }

    public function store(CouponRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->store($request->validated());
        return back();
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('coupon::show')->with([
            'coupon' => $this->repository->show($id)
        ]);
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('coupon::edit')->with([
            'coupon' => $this->repository->find($id)
        ]);
    }

    public function update(CouponRequest $request, $id): \Illuminate\Http\RedirectResponse
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
