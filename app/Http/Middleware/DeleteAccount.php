<?php

namespace App\Http\Middleware;

use Closure;   
use DB;
use Auth;
class DeleteAccount
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
        
       $user = Auth::user();

       if($user->delete_status == '2') {
          	return response()->json(['message' => 'Your account has been deleted by admin'], 405);
        }
        return $next($request);
    }
}
