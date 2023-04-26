<?php

namespace Birakdar\EasyBuild;

use Birakdar\EasyBuild\Commands\GenerateModule;
use Birakdar\EasyBuild\Commands\InstallCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideCreateModuleRepositoryCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideControllerMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideFactoryMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideMigrationMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideModelMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideModuleMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideProviderMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideRequestMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideResourceMakeCommand;
use Birakdar\EasyBuild\Commands\OverrideCommands\OverrideSeedMakeCommand;
use Illuminate\Support\ServiceProvider;

class EasyBuildServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/easy-build.php', 'easy-build');
//        $this->loadRoutesFrom(__DIR__ . '/routes/auth.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'easy-build');
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                GenerateModule::class,
                OverrideCreateModuleRepositoryCommand::class,
                OverrideControllerMakeCommand::class,
                OverrideFactoryMakeCommand::class,
                OverrideModelMakeCommand::class,
                OverrideModuleMakeCommand::class,
                OverrideProviderMakeCommand::class,
                OverrideRequestMakeCommand::class,
                OverrideResourceMakeCommand::class,
                OverrideSeedMakeCommand::class,
                OverrideMigrationMakeCommand::class,
            ]);
        }
        $this->checkRouteFile();
        $this->publish();
    }

    private function publish()
    {
        $this->publishes([
            __DIR__ . '/public' => public_path('easy-build'),
        ], 'easy-build-assets');
        $this->publishes([
            __DIR__ . '/routes/auth.php' => base_path('routes/auth.php'),
        ], 'easy-build-route');
    }

    public function checkRouteFile()
    {
        if (file_exists(base_path('routes/auth.php'))) {
            require_once base_path('routes/auth.php');
        }
    }

    public function register()
    {

    }
}
