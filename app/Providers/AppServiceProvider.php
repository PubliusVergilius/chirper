<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str as SupportStr;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * BUG: I tried to log all DB queries with the below code
         * But some POST queries are causing a infinite loop
         **
        if (App::environment('local')) {
            DB::listen(function ($query) {
                logger(SupportStr::replaceArray('?', $query->bindings, $query->sql));
            });
        }
         */

        Model::preventLazyLoading(! $this->app->isProduction());
    }
}
