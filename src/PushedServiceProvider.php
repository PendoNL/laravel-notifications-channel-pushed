<?php

namespace PendoNL\LaravelNotificationsChannelPushed;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class PushedServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(PushedChannel::class)
            ->needs(Pushed::class)
            ->give(function () {
                $config = config('services.pushed');

                return new Pushed($config['app_key'], $config['app_secret'], new HttpClient);
            });
    }
}
