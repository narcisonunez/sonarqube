<?php

namespace App\Providers;

use App\Services\InstagramGraph\InstagramService;
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
	    $this->app->bind(InstagramService::class, function ($app){
		    return new InstagramService($app['config']['instagram-feed']['access_token'], $app['config']['instagram-feed']['feed_limit']);
	    });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
