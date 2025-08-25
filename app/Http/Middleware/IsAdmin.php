<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()) {
            return redirect()->route("admin.login");
        }
        // if (auth()->user() && auth()->user()->role_id != '1') {
        //     return redirect()->back()->with("error","You are not allowed!");
        // }
        return $next($request);
    }
}
