<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub2;
use Nwidart\Modules\Commands\MigrationMakeCommand;
use Nwidart\Modules\Support\Migrations\NameParser;

class OverrideMigrationMakeCommand extends MigrationMakeCommand
{
    protected $signature = 'override-migration-make-command {name} {module} {--fields} {--plain}';

    protected function getTemplateContents()
    {
        $parser = new NameParser($this->argument('name'));
        if ($parser->isCreate()) {
            return OverrideStub::create('/migration/create.stub', [
                'class' => $this->getClass(),
                'table' => $parser->getTableName(),
                'fields' => $this->getSchemaParser()->render(),
            ]);
        }
    }
}
