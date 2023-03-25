<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideStub;
use Illuminate\Support\Str;
use Nwidart\Modules\Commands\ModelMakeCommand;
use Nwidart\Modules\Exceptions\FileAlreadyExistException;
use Nwidart\Modules\Generators\FileGenerator;

class OverrideModelMakeCommand extends ModelMakeCommand
{
    protected $signature = 'override-model-make-command {model} {module} {--fillable} {--migration} {--m} {--controller} {--c} {--seed} {--s} {--request} {--r}';

    public function handle(): int
    {
        $path = str_replace('\\', '/', $this->getDestinationFilePath());
        if (!$this->laravel['files']->isDirectory($dir = dirname($path))) {
            $this->laravel['files']->makeDirectory($dir, 0777, true);
        }
        $contents = $this->getTemplateContents();
        $this->components->task("Generating file {$path}",function () use ($path,$contents) {
            $overwriteFile = $this->hasOption('force') ? $this->option('force') : false;
            (new FileGenerator($path, $contents))->withFileOverwrite($overwriteFile)->generate();
        });
        $this->handleOptionalMigrationOption();
        return 0;
    }

    protected function getTemplateContents(): string
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new OverrideStub('/model.stub', [
            'NAME'              => $this->getModelName(),
            'FILLABLE'          => $this->getFillable(),
            'NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'             => $this->getClass(),
            'LOWER_NAME'        => $module->getLowerName(),
            'LOWER_NAME_PLURAL'        => $this->getLowerNamePluralReplacement(),
            'MODULE'            => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    private function getModelName(): string
    {
        return Str::studly($this->argument('model'));
    }

    private function getFillable(): bool|string
    {
        $fillable = $this->option('fillable');

        if (!is_null($fillable)) {
            $arrays = explode(',', $fillable);

            return json_encode($arrays);
        }

        return '[]';
    }

    protected function getLowerNamePluralReplacement(): string
    {
        return Str::plural(strtolower($this->argument('model')));
    }

    private function handleOptionalMigrationOption()
    {
        if ($this->option('migration') === true) {
            $migrationName = 'create_' . $this->createMigrationName() . '_table';
            $this->call('override-migration-make-command', ['name' => $migrationName, 'module' => $this->argument('module')]);
        }
    }

    private function createMigrationName(): string
    {
        $pieces = preg_split('/(?=[A-Z])/', $this->argument('model'), -1, PREG_SPLIT_NO_EMPTY);

        $string = '';
        foreach ($pieces as $i => $piece) {
            if ($i+1 < count($pieces)) {
                $string .= strtolower($piece) . '_';
            } else {
                $string .= Str::plural(strtolower($piece));
            }
        }

        return $string;
    }
}
