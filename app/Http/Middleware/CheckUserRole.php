<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Check if user is authenticated and has one of the specified roles
        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect if user is not authenticated or does not have the required role
        return redirect('/');
    }
}
