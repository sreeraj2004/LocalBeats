<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        Log::info('RedirectIfAuthenticated middleware called', [
            'session_has_user_id' => session()->has('user_id'),
            'user_id' => session('user_id')
        ]);
        
        if (session()->has('user_id')) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
