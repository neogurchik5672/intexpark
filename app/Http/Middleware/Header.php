<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Header
{
    public function handle($request, Closure $next)
    {
        // Проверяем аутентификацию пользователя
        if (Auth::check()) {
            $user = User::find(Auth::id());
            
            if ($user) {
                View::share('userHeader', $user);
            } else {
                try {
                    Artisan::call('db:seed', ['--class' => 'UserSeeder']);
                    $user = User::query()->where('id',Auth::user()->id)->first();
                    View::share('userHeader', $user);
                } catch (\Exception $e) {
                    logger()->error('Ошибка наполнения пользователями: ' . $e->getMessage());
                }
            }
        }

        // Важно: всегда возвращаем следующий middleware
        return $next($request);
    }
}