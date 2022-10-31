<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DoctorCheck
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
        if(!session()->has('LoggedDoctor') && ($request->path() != 'doctor/login' && $request->path() != 'doctor/register')){
            return redirect()->route('doctor.login')->with('error', 'You must login first!');
        }

        if(session()->has('LoggedDoctor') && ($request->path() == 'doctor/login' || $request->path() == 'doctor/register')){
            return redirect()->route('doctor.dashboard');
        }
        return $next($request)->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
                                            ->header('Pragma', 'no-cache')
                                            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
