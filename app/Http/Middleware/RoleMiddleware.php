<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || !$this->checkUserRole($user, $role)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }

    private function checkUserRole($user, $role)
    {
        // Query roles directly from the database
        return $user->roles()->where('name', $role)->exists();
    }
}
