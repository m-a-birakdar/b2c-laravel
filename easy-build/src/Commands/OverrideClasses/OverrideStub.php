<?php

namespace Birakdar\EasyBuild\Commands\OverrideClasses;

use Nwidart\Modules\Support\Stub;

class OverrideStub extends Stub
{
    public function getPath()
    {
        return base_path('vendor/birakdar/easy-build/src/Commands/stubs' . $this->path);
    }

    public function setPath($path)
    {
        $this->path = base_path('vendor/birakdar/easy-build/src/Commands/stubs' . $path);
    }
}
