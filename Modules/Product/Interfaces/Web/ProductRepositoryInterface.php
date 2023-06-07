<?php

namespace Modules\Product\Interfaces\Web;

use Birakdar\EasyBuild\Interfaces\BaseInterface;

interface ProductRepositoryInterface extends BaseInterface
{
    public function exists($id);
}
