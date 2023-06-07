<?php

namespace Modules\Report\Http\Controllers\DaApi;

use App\Exceptions\DashboardApiException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Repositories\Web\ProductRepository;
use Modules\Report\Enums\TypeEnum;
use Modules\Report\Interfaces\DaApi\ProductReportRepositoryInterface;

class ProductReportController extends Controller
{
    public ProductReportRepositoryInterface $repository;

    public function __construct(ProductReportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        $this->validate($request);
        return $this->repository->show($request->input('product_id'), $request->input('type'), $this->values);
    }

    public function index(Request $request)
    {
        $this->validate($request);
        return $this->repository->index($request->input('product_id'), $request->input('type'), $this->values);
    }

    private function validate(Request $request)
    {
        if (
            ! $request->has('product_id') || ! $request->has('type') || ! in_array($request->has('type'), array_column(TypeEnum::cases(), 'value')) ||
            ! $this->validateProduct($request->input('product_id')) || ! $this->validateType($request->input('type'), $request->all())
        )
            throw new DashboardApiException();
    }

    private function validateProduct($id): bool
    {
        $ids = is_string($id) ? explode(',', $id) : (array) $id;
        foreach ($ids as $id) {
            if (! ( new ProductRepository )->exists($id))
                return false;
        }
        return true;
    }

    private array $values = [];

    private function validateType($type, $request): bool
    {
        $types = match ($type){
            TypeEnum::YEARLY->value => [
                'y'
            ],
            TypeEnum::MONTHLY->value => [
                'y', 'm'
            ],
            TypeEnum::WEEKLY->value, TypeEnum::DAILY->value => [
                'y', 'm', 'd'
            ],
        };
        $keys = array_keys($request);
        foreach ($types as $new){
            if (! in_array($new, $keys))
                return false;
        }
        $this->values = array_intersect_key($request, array_flip($types));
        return true;
    }
}
