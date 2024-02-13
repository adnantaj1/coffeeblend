<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckForPrice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Assuming 'products/checkout' and 'products/success' are paths and not named routes
        if ($request->is('products/checkout') || $request->is('products/success')) {
            if (Session::get('price') == 0) {
                return abort(403); // Use abort(403) directly
            }
        }
        return $next($request);
    }
}
