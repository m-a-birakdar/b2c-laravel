<?php

namespace Modules\Category\Interfaces\Web;

use Birakdar\EasyBuild\Interfaces\BaseInterface;

interface CategoryRepositoryInterface extends BaseInterface
{
    public function checkBeforeDelete($id);
}
