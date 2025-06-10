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
        if ($request->is('api/telegram/webhook')) {
            return $next($request);
        }
        // Проверяем аутентификацию пользователя
        if (Auth::check()) {
            $user = User::find(Auth::id()); 
            View::share('userHeader',$user);
            }else{
                  abort(401, 'Вы не авторизованны.');
            }
        return $next($request);
    }
}
