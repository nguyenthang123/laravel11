<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class SetGuardSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard): Response
    {
        if ($guard === 'admin') {
            Config::set('session.cookie', 'admin_cookie'); // Sử dụng session riêng cho admin
        } else {
            Config::set('session.cookie', 'web_cookie'); // Sử dụng session riêng cho user
        }
        return $next($request);
    }
}
