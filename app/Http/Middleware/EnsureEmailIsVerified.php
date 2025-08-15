<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')
                ->with('error', 'Please verify your email address first.');
        }

        return $next($request);
    }
}
