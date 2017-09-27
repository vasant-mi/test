<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $adminNamespace = 'App\Admin\Controllers';
    protected $webNamespace = 'App\Web\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

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

        $this->mapAdminRoutes();

        $this->mapWebRoutes();

        //
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
        $api = app('Dingo\Api\Routing\Router');
        $api->version(['v1'], [], function (\Dingo\Api\Routing\Router $api) {
            $api->group(['namespace' => 'App\Api\V1\Controllers'], function (\Dingo\Api\Routing\Router $api) {
                require_once app_path('Api/V1/routes.php');
            });
        });
    }

    protected function mapAdminRoutes()
    {
        Route::group(['namespace' => $this->adminNamespace, 'middleware' => ['web'], 'prefix' => 'Admin'], function (){
            include_once base_path('routes/admin.php');
        });
    }

    protected function mapWebRoutes()
    {
        Route::group(['namespace' => $this->webNamespace, 'middleware' => ['web']], function (){
            include_once base_path('routes/web.php');
        });
    }
}
