<?php

namespace Modules\Currency\Http\Controllers\AdApi\V1;

use App\Http\Resources\MainResource;
use App\Traits\ModelExistsTrait;
use Illuminate\Routing\Controller;
use Modules\Currency\Http\Requests\AdApi\V1\CurrencyRequest;
use Modules\Currency\Interfaces\AdApi\V1\CurrencyRepositoryInterface;
use Modules\Currency\Transformers\AdApi\V1\CurrencyResource;

class CurrencyController extends Controller
{
    use ModelExistsTrait;

    public CurrencyRepositoryInterface $repository;

    public function __construct(CurrencyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show($id): CurrencyResource
    {
        $this->exists(['currency' => $id]);
        return CurrencyResource::make($this->repository->show($id));
    }

    public function update(CurrencyRequest $request, $id): MainResource
    {
        return MainResource::make(null, $this->repository->update($request->validated(), $id));
    }
}
