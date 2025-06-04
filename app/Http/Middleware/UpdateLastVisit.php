<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UpdateLastVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            if ($user->last_visit) {
                $mintesToAdd = now()->diffInMinutes($user->last_visit);
                $user->increment('total_time_spent', $mintesToAdd);
            }

            if (!$user->last_visit || now()->diffInMinutes($user->last_visit) > 5) {
                $user->update(['last_visit' => now()]);
            }
        }
        return $next($request);
    }
}
