<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            if (Auth::user()->role === 'Admin' && Auth::user()->status === 'Active') {
                if (!str_starts_with($request->path(), 'admin')) {
                    return redirect('/admin');
                } else {
                    return $next($request);
                }
            } elseif (Auth::user()->role === 'Cashier' && Auth::user()->status === 'Active') {
                if ($request->path() !== 'cashier') {
                    return redirect('/cashier');
                } else {
                    return $next($request);
                }
            } else {
                // return redirect('/logout');
            }
        }

         return redirect('/');
    }
}
