<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect(route('user.login'));         
        }

        $user = Auth::user();
        
        if ($user->role && strtolower($user->role->name) == strtolower($role)) {
            return $next($request);
        }
        return abort(403, 'Unauthorized action. You do not have the required role.');
    }
}