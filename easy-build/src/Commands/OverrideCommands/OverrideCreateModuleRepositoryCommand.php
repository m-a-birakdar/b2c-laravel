<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Illuminate\Support\Str;
use Theanik\LaravelMoreCommand\Commands\CreateModuleRepositoryCommand;
use Theanik\LaravelMoreCommand\Support\GenerateFile;

class OverrideCreateModuleRepositoryCommand extends CreateModuleRepositoryCommand
{
    protected $signature = 'generate:repository {--interface} {--i} {repository} {module}';

    protected function interfaceDestinationPath(): string
    {
        return base_path() . "/Modules/{$this->argument('module')}" . "/Interfaces/" . $this->getInterfaceName() . '.php';
    }

    public function getDefaultInterfaceNamespace() : string
    {
        return "Modules\\{$this->argument('module')}\\Interfaces";
    }

    protected function getInterfaceTemplateContents(): string
    {
        return (new GenerateFile(base_path('vendor/birakdar/easy-build/src/Commands/stubs/interface.stub'), [
            'CLASS_NAMESPACE'   => $this->getInterfaceNamespace(),
            'INTERFACE'         => class_basename($this->getInterfaceName())
        ]))->render();
    }

    protected function getTemplateContents(): string
    {
        return (new GenerateFile(base_path($this->getStubName()), [
            'CLASS_NAMESPACE'   => $this->getClassNamespace(),
            'INTERFACE_NAMESPACE'   => $this->getInterfaceNamespace().'\\'. class_basename($this->getInterfaceName()),
            'CLASS'             => class_basename($this->getRepositoryName2()),
            'INTERFACE'         => class_basename($this->getInterfaceName()),
            'STUDLY_NAME'         => $this->argument('module'),
            'LOWER_NAME'         => Str::lower($this->argument('module')),
        ]))->render();
    }

    public function getRepositoryName2(): string
    {
        $repository = Str::studly($this->argument('repository'));
        if (Str::contains(strtolower($repository), 'repository') === false)
            $repository .= 'Repository';
        return $repository;
    }
    protected function getStubName(): string
    {
        if ($this->option('interface') === true) {
            $stub = '/vendor/birakdar/easy-build/src/Commands/stubs/repository-interface.stub';
        } else {
            $stub = '/vendor/birakdar/easy-build/src/Commands/stubs/repository.stub';
        }
        return $stub;
    }
}
