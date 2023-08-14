<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            //frontend.components.header là view cần share data
            // 'frontend.components.header', 'App\Http\View\Composers\HeaderComposer'
            'layouts.frontend', 'App\Http\View\Composers\HeaderComposer'
        );
 
    }
}
