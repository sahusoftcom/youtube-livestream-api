<?php

namespace sahusoftcom\YoutubeApi;

use Illuminate\Support\ServiceProvider;

class LiveStreamApiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(array(__DIR__ . '/config/google.php' => config_path('google.php')),'youtube-config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

    }
}