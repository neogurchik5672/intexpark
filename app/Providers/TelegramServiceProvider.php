<?php

namespace App\Providers;

use SocialiteProviders\Manager\SocialiteWasCalled;

class TelegramServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'telegram',
            function ($app) use ($socialite) {
                $config = $app['config']['services.telegram'];
                return $socialite->buildProvider(SocialiteProviders\Telegram\Provider::class, $config);
            }
        );
    }
}