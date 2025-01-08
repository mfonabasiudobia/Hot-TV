<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubscriptionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if(!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('dashboard.index');
        }

        if(!$user->subscription
            || $user->subscription->status !== "active"
            || $user->subscription->status !== "trialing")
        {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Not Subscribed'], 402);
            }

            return redirect()->route('dashboard.index');
        }

        return $next($request);
    }
}
