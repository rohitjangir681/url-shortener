<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role === 'superadmin' && !$request->user()->isSuperAdmin()) {
            abort(403);
        }

        if ($role === 'admin' && !$request->user()->isAdmin()) {
            abort(403);
        }

        if ($role === 'member' && !$request->user()->isMember()) {
            abort(403);
        }

        return $next($request);
    }
}