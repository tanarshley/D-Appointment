<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCheck
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
        if(!session()->has('LoggedAdmin') && ($request->path() != 'admin/login' && $request->path() !='admin/dashboard' && $request->path() != 'admin/register')){
            return redirect()->route('admin.login')->with('error', 'You must login first!');
        }

        if(session()->has('LoggedAdmin') && ($request->path() == 'admin/login' || $request->path() == 'admin/register')){
            return redirect()->route('admin.dashboard');
        }
        return $next($request)->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                                            ->header('Pragma', 'no-cache')
                                            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
