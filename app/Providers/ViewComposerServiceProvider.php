<?php

namespace App\Providers;

use App\Http\View\Composers\MultiComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'layouts.footer',
                'components.frontend.layout.navigation',
                'pages.404.episodes',
                'pages.home.index',
                'pages.subscribe.index',
                'pages.press.index'
            ],
            MultiComposer::class
        );
    }
}
