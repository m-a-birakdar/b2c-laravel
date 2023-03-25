<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\FactoryMakeCommand;

class OverrideFactoryMakeCommand extends FactoryMakeCommand
{
    protected $signature = 'override-factory-make-command {name} {module}';

    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new OverrideStub('/factory.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'NAME' => $this->getModelName(),
            'MODEL_NAMESPACE' => $this->getModelNamespace(),
        ]))->render();
    }

    private function getModelName()
    {
        return Str::studly($this->argument('name'));
    }
}
