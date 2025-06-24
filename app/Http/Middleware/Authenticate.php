<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        // Customize redirection logic
        if ($request->is('admin') || $request->routeIs('admin.*')) {
            return route('admin.login');
        }

        if ($request->is('parent') || $request->routeIs('parent.*')) {
            return route('parent.login');
        }

        if ($request->is('staff') || $request->routeIs('staff.*')) {
            return route('staff.login');
        }

        return route('login');
    }
}
