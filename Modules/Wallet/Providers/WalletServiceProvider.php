<?php

namespace Modules\Wallet\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Wallet\Interfaces\CuApi\V1\CardRepositoryInterface;
use Modules\Wallet\Interfaces\CuApi\V1\TransactionRepositoryInterface;
use Modules\Wallet\Repositories\Api\V1\CardRepository;
use Modules\Wallet\Repositories\CuApi\V1\TransactionRepository;

class WalletServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Wallet';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'wallet';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */

    private array $bind = [
        \Modules\Wallet\Interfaces\Web\WalletRepositoryInterface::class => \Modules\Wallet\Repositories\Web\WalletRepository::class,
        \Modules\Wallet\Interfaces\CuApi\V1\WalletRepositoryInterface::class => \Modules\Wallet\Repositories\CuApi\V1\WalletRepository::class,
        TransactionRepositoryInterface::class => TransactionRepository::class,
        CardRepositoryInterface::class => CardRepository::class,
    ];

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        foreach ($this->bind as $key => $value)
            $this->app->bind($key, $value);
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
