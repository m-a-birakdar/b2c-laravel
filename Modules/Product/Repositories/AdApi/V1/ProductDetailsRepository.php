<?php

namespace Modules\Product\Repositories\AdApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Product\Entities\ProductDetails;

class ProductDetailsRepository
{
    use BaseRepositoryTrait;

    public ProductDetails|null $model;

    public function __construct(ProductDetails $model = new ProductDetails())
    {
        $this->model = $model;
    }

    public function update($array): bool
    {
        return $this->model->update($array);
    }
}
