<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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
         // Только для web-интерфейса (исключая API и Telegram)
    View::composer('*', function ($view) {
        if (request()->is(['api/*', 'telegram/webhook'])) {
            return;
        }
        
        $view->with([
            'userHeader' => Auth::user(),
            'isAuthenticated' => Auth::check()
        ]);
    });
    }
}
