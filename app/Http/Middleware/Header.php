<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Header
{
    public function handle(Request $request, Closure $next): Response
    {
 if (auth()->check() && auth()->user()->is_banned) {
            // Если пользователь уже на странице бана - пропускаем
            if ($request->routeIs('banned')) {
                return $next($request);
            }
            
            // Перенаправляем на страницу бана
            return redirect()->route('banned')->with([
                'message' => "Ваш аккаунт заблокирован. Причина: " . auth()->user()->ban_reason,
            ]);
        }

        return $next($request);
    }
}
