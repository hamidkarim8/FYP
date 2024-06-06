<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();
        
        if (!$user || !$user->hasRole($role)) {
            Log::warning('Unauthorized access attempt', ['role' => $role, 'user' => $user]);
            return redirect()->route('root');
        }

        return $next($request);
    }
}


