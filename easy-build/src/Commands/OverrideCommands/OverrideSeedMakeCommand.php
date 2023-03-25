<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\SeedMakeCommand;

class OverrideSeedMakeCommand extends SeedMakeCommand
{
    protected $signature = 'override-seed-make-command {name} {module} {--master}';

    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new OverrideStub('/seeder.stub', [
            'NAME' => $this->getSeederName(),
            'MODULE' => $this->getModuleName(),
            'NAMESPACE' => $this->getClassNamespace($module),
        ]))->render();
    }

    private function getSeederName(): string
    {
        $end = $this->option('master') ? 'DatabaseSeeder' : 'TableSeeder';

        return Str::studly($this->argument('name')) . $end;
    }
}
