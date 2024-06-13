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
        if (!Auth::check()) {

            return redirect('/');
        }


        //* check if may role ka na 1 and active ang status
        //* check if ang routes mo is nasa admin
        //* pag hindi ibalik ka sa admin

        if (Auth::user()->user_role_id == 1 && Auth::user()->status === 'Active') {

            if (!str_starts_with($request->path(), 'admin')) {

                return redirect('/admin');
            }

            return $next($request);
        }

        //* check if may role ka na 1 and active ang status
        //* check if ang routes mo is nasa cashier
        //* pag hindi ibalik ka sa cashier

        if (Auth::user()->user_role_id === '2' && Auth::user()->status === 'Active') {

            if ($request->path() !== 'cashier') {

                return redirect('/cashier');
            }

            return $next($request);
        }

        return $next($request);
    }
}
