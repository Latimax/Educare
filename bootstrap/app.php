<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ParentMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix('parent')
                ->name('parent.')
                ->group(base_path('routes/parent.php'));

        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class, //Register the AdminMiddleware
            'parent' => ParentMiddleware::class, //Register the ParentMiddleware
        ]);

        $middleware->redirectGuestsTo(function (Illuminate\Http\Request $request) {
            // If the route name matches 'admin.*', redirect to admin login
            if ($request->routeIs('admin.*') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // If the route name matches 'parent.*', redirect to admin login
            if ($request->routeIs('parent.*') || $request->is('parent/*')) {
                return route('parent.login');
            }

            // Default redirect for other guests
            return route('login');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
