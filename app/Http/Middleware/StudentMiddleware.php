<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = 'student'): Response
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('student.login')->with('status', 'You must be logged in as an student to access this area.');
        }

        return $next($request);
    }
}
