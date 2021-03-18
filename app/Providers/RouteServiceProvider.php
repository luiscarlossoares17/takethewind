<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}


/*namespace App\Providers;

use App\Equipment;
use App\Location;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{ */
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    //protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    /*public function boot()
    {
        parent::boot();

        Route::bind('location',function ($value){
            return Location::where('name', 'LIKE', $value)
                ->orWhere('id', 'LIKE', $value)
                ->firstOrFail();
        });
        Route::bind('equipment',function ($value){
            return Equipment::where('name', 'LIKE', $value)
                ->orWhere('id', 'LIKE', $value)
                ->firstOrFail();
        });
    }*/

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    /*public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

    }*/

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    /*protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->namespace('App\Http\Controllers\Frontoffice')
            ->group(base_path('routes/frontoffice.php'));

        Route::middleware('web')
            ->namespace('App\Http\Controllers\Backoffice')
            ->prefix('backoffice')
            ->group(base_path('routes/backoffice.php'));

        //Dashboard Mode
        Route::middleware('web')
            ->namespace('App\Http\Controllers\Frontoffice')
            ->prefix('dashboardmode')
            ->group(base_path('routes/dashboardmode.php'));
    }*/

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    /*protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    } 
}*/