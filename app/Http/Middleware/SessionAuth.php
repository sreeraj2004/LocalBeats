<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SessionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('SessionAuth middleware called', [
            'session_has_user_id' => session()->has('user_id'),
            'user_id' => session('user_id')
        ]);
        
        if (!session()->has('user_id')) {
            Log::warning('User not authenticated, redirecting to login');
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }
        
        return $next($request);
    }
} 