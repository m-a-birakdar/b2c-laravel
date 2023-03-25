<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Nwidart\Modules\Commands\ControllerMakeCommand;

class OverrideControllerMakeCommand extends ControllerMakeCommand
{
    protected $signature = 'override-controller-make-command {controller} {module} {--plain} {--p} {--api}';

    /**
     * @return string
     */
    protected function getTemplateContents(): string
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new OverrideStub($this->getStubName(), [
            'MODULENAME'        => $module->getStudlyName(),
            'CONTROLLERNAME'    => $this->getControllerName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getControllerNameWithoutNamespace(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    private function getControllerNameWithoutNamespace(): array|string
    {
        return class_basename($this->getControllerName());
    }
}
