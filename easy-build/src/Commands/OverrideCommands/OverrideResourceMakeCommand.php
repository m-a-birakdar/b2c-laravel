<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Nwidart\Modules\Commands\ResourceMakeCommand;

class OverrideResourceMakeCommand extends ResourceMakeCommand
{
    protected $signature = 'override-resource-make-command {name} {module} {--collection} {--c}';

    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new OverrideStub($this->getStubName(), [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS'     => $this->getClass(),
        ]))->render();
    }
}
