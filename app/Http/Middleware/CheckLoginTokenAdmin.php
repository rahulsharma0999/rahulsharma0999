<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginTokenAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session_token = $request->session()->get('login_token');
        $token = auth()->user()->login_token;

        if($session_token != $token) {
            auth()->logout();
            return redirect('superAdmin/login');
        }
        return $next($request);
    }
}
