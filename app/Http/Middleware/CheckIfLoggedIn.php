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
            //* check if may role ka na 1 and active ang status mo para makalogin ka sa admin
            if (Auth::user()->user_role_id == 1 && Auth::user()->status === 'Active') {

                return redirect('/admin');

                //* check if may role ka na 2 and active ang status mo para makalogin ka sa cashier
            } elseif (Auth::user()->user_role_id == 2 && Auth::user()->status === 'Active') {

                return redirect('/cashier');
            } else {
               
            }
        }
        return $next($request);
    }
}
