<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\ProviderMakeCommand;
use Nwidart\Modules\Module;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;

class OverrideProviderMakeCommand extends ProviderMakeCommand
{
    protected $signature = 'override-provider-make-command {name} {module} {--master}';

    protected function getTemplateContents()
    {
        $stub = $this->option('master') ? 'scaffold/provider' : 'provider';

        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new OverrideStub('/' . $stub . '.stub', [
            'NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'             => $this->getClass(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getFileName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
            'PATH_VIEWS'        => GenerateConfigReader::read('views')->getPath(),
            'PATH_LANG'         => GenerateConfigReader::read('lang')->getPath(),
            'PATH_CONFIG'       => GenerateConfigReader::read('config')->getPath(),
            'MIGRATIONS_PATH'   => GenerateConfigReader::read('migration')->getPath(),
            'FACTORIES_PATH'    => GenerateConfigReader::read('factory')->getPath(),
        ]))->render();
    }

    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }
}
