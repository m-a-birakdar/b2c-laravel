<?php

namespace Birakdar\EasyBuild\Commands\OverrideCommands;

use Birakdar\EasyBuild\Commands\OverrideClasses\OverrideModuleGenerator;
use Nwidart\Modules\Commands\ModuleMakeCommand;
use Nwidart\Modules\Contracts\ActivatorInterface;

class OverrideModuleMakeCommand extends ModuleMakeCommand
{
    protected $signature = 'override-module-make-command {name*} {--force} {--plain} {--api} {--p} {--web} {--disabled} {--d} {--m}';

    protected $description = 'override-module-make-command';

    public function handle(): int
    {
        $names = $this->argument('name');
        $success = true;

        foreach ($names as $name) {
            $code = with(new OverrideModuleGenerator($name))
                ->setFilesystem($this->laravel['files'])
                ->setModule($this->laravel['modules'])
                ->setConfig($this->laravel['config'])
                ->setActivator($this->laravel[ActivatorInterface::class])
                ->setConsole($this)
                ->setComponent($this->components)
                ->setForce($this->option('force'))
                ->setType($this->getModuleType())
                ->setActive(!$this->option('disabled'))
                ->generate();

            if ($code === E_ERROR) {
                $success = false;
            }
        }

        return $success ? 0 : E_ERROR;
    }
    /**
     * Get module type .
     *
     * @return string
     */
    private function getModuleType(): string
    {
        $isPlain = $this->option('plain');
        $isApi = $this->option('api');

        if ($isPlain && $isApi) {
            return 'web';
        }
        if ($isPlain) {
            return 'plain';
        } elseif ($isApi) {
            return 'api';
        } else {
            return 'web';
        }
    }
}
