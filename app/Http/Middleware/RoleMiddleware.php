<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            abort(403); // tidak login
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(404, 'halaman tidak adai.');
        }

        return $next($request);
    }
}

