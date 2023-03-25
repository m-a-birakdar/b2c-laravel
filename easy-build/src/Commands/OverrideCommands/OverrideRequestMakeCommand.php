<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Nwidart\Modules\Commands\RequestMakeCommand;

class OverrideRequestMakeCommand extends RequestMakeCommand
{
    protected $signature = 'override-request-make-command {name} {module}';

    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new OverrideStub('/request.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS'     => $this->getClass(),
        ]))->render();
    }
}
