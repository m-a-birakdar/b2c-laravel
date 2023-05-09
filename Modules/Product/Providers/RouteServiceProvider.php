<?php

namespace Modules\Product\Providers;

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
    protected $moduleNamespace = 'Modules\Product\Http\Controllers';

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

        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware(['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->namespace($this->moduleNamespace)
            ->group(module_path('Product', '/Routes/web.php'));
    }

    protected function mapCuApiRoutes()
    {
        Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->prefix('cu-api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Product', '/Routes/CuApi.php'));
    }

    protected function mapCoApiRoutes()
    {
        Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->prefix('ad-api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Product', '/Routes/AdApi.php'));
    }
}
