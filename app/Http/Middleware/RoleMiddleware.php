<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Anda belum login.');
        }

        if ($roles === []) {
            return $next($request);
        }

        foreach ($roles as $role) {
            $normalizedRole = $role === 'user' ? ['user', 'member'] : [$role];

            if (in_array($user->role, $normalizedRole, true)) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak untuk role Anda.');
    }
}
