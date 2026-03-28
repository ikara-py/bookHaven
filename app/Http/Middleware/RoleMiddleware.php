<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        $user = Auth::user();

        foreach($roles as $role){
            if($role === 'seller' && $user->isSeller()) return $next($request);
            if ($role === 'buyer'  && $user->isBuyer())  return $next($request);
            if ($role === 'admin'  && $user->isAdmin())  return $next($request);
        }

        abort(403, 'You do not have permission to access this page.');
    }
}
