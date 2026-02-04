<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if user is logged in AND is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Allow access
        }

        // 2. If not, block them and send them back
        abort(403, 'Unauthorized action. Access denied.');
    }
}