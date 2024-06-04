<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->user_role_id == 1 && Auth::user()->status === 'Active') {

                    return redirect('/admin');

            } elseif (Auth::user()->role === 'Cashier' && Auth::user()->status === 'Active') {

                    return redirect('/cashier');

            } else {
                // return redirect('/logout');
            }
        }
        return $next($request);
    }
}
