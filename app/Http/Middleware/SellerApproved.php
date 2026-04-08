<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if (!$user || !$user->sellerProfile || !$user->sellerProfile->is_approved) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your seller account is awaiting admin approval.'], 403);
            }

            return redirect()->route('seller.dashboard')->with('warning', 'Your seller account is awaiting admin approval before you can manage listings.');
        }

        return $next($request);
    }
}
