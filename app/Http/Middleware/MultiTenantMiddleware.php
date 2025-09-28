<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MultiTenantMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is a house owner
        if (auth()->check() && auth()->user()->role === 'house_owner') {
            // Multi-tenant scoping is handled by global scopes in models
            // This middleware can be extended for additional tenant-specific logic

            // You could also implement subdomain-based tenant identification here
            // For example:
            // $subdomain = explode('.', $request->getHost())[0];
            // if ($subdomain !== 'www' && $subdomain !== env('APP_DOMAIN')) {
            //     // Handle subdomain-based tenant identification
            // }
        }

        // Admin users bypass all tenant restrictions (handled in model scopes)
        return $next($request);
    }
}
