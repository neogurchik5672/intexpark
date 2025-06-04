<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelegramAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Если пользователь уже авторизован - пропускаем
        if (Auth::check()) {
            return $next($request);
        }

        // Пытаемся авторизовать через Telegram WebApp данные
        if ($request->has('tgWebAppData')) {
            $initData = $request->input('tgWebAppData');
            
            // Здесь можно добавить вызов autoAuth, но лучше через AJAX
            return redirect()->route('telegram.autoAuth', ['initData' => $initData]);
        }

        // Если это AJAX запрос - возвращаем JSON ошибку
        if ($request->wantsJson()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Для обычных запросов можно сделать редирект
        return response('Unauthorized', 401);
    }
}
