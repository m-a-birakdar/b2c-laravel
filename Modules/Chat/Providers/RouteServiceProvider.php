<?php

namespace Modules\Chat\Providers;

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
    protected $moduleNamespace = 'Modules\Chat\Http\Controllers';

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
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAjaxRoutes();
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
            ->group(module_path('Chat', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])
            ->prefix('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Chat', '/Routes/api.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::middleware(['check_is_ajax', 'web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])
            ->prefix('ajax/chat')
            ->name('chat.')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Chat', '/Routes/ajax.php'));
    }
}
