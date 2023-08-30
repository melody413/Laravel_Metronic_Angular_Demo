<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        //
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        //view component
        Blade::aliasComponent('admin.components.content_block', 'admin_block');

        Blade::aliasComponent('frontend.components.unit_block', 'unit_block');
        Blade::aliasComponent('frontend.components.list_block', 'list_block');

        if(env('REDIRECT_HTTPS')) {
            \URL::forceScheme('https');
        }

        // \DB::listen(function ($query) {
        //     var_dump([
        //         $query->sql,
        //         $query->bindings,
        //         $query->time
        //     ]);
        // });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (App::environment('local') && env('APP_URL') == 'http://localhost') {
            Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
                // filter oauth ones
                if (!str_contains($query->sql, 'oauth')) {
                    Log::debug($query->sql . ' - ' . serialize($query->bindings));
                }
            });
        }

    }
}
