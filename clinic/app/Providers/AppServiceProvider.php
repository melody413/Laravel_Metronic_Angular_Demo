<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // if(env('REDIRECT_HTTPS')) {
            \URL::forceScheme('https');
        // }

        Blade::if('doctor',function (){
            return auth()->check() && auth()->user()->role == 1;
        });
        Blade::if('assistant',function (){
            return auth()->check() && auth()->user()->role == 2;
        });
        Blade::if('patient',function (){
            return auth()->check() && auth()->user()->role == 3;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
