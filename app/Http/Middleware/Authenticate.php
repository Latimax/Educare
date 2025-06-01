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

        return route('login');
    }
}
