<?php

namespace Modules\User\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\User\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapCuApiRoutes();

        $this->mapCoApiRoutes();

        $this->mapAdApiRoutes();

        $this->mapWebRoutes();

        $this->mapAuthRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->namespace($this->moduleNamespace)
            ->group(module_path('User', '/Routes/web.php'));
    }

    protected function mapAuthRoutes()
    {
        Route::middleware(['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->namespace($this->moduleNamespace)->prefix('auth')
            ->group(module_path('User', '/Routes/auth.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCuApiRoutes()
    {
        Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->prefix('cu-api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('User', '/Routes/CuApi.php'));
    }

    protected function mapCoApiRoutes()
    {
        Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->prefix('co-api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('User', '/Routes/CoApi.php'));
    }

    protected function mapAdApiRoutes()
    {
        Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->prefix('ad-api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('User', '/Routes/AdApi.php'));
    }
}
