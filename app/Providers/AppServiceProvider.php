<?php

namespace App\Providers;

use App\Models\config as ActiveConfig;
use App\Models\Triwulan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer('layouts.admin', function ($view) {
            $data = $view->getData();
            if (!isset($data['triwulan']) && Schema::hasTable('triwulans')) {
                $view->with('triwulan', Triwulan::where('status', '=', '1')->first());
            }
            if (!isset($data['actConfig']) && Schema::hasTable('configs')) {
                $view->with('actConfig', ActiveConfig::where('status', '=', '1')->first());
            }
        });
    }
}
