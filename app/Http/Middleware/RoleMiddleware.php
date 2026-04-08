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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        foreach($roles as $role){
            if($role === 'seller' && in_array($user->role, ['seller', 'buyer_seller', 'seller_buyer'])) return $next($request);
            if ($role === 'buyer'  && in_array($user->role, ['buyer', 'buyer_seller', 'seller_buyer']))  return $next($request);
            if ($role === 'admin'  && $user->role === 'admin')  return $next($request);
        }

        $roleList = implode(', ', $roles);
        abort(403, "You do not have permission to access this page. (User Role: '{$user->role}', Allowed: [{$roleList}])");
    }
}
