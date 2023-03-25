<?php

namespace App\Http\Middleware;

use Closure;   
use DB;
use Auth;
class CheckBlock
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
        
       $userId = Auth::user()->id;

        $get_admin=DB::table('users')->where(['id'=>$userId])->first();
       if($get_admin->block_status == '2') {
			//return response()->json(['error' => 'Work is in progress,please wait'], 405);
			return response()->json(['message' => 'You are blocked by admin'], 405);
        }
        return $next($request);
    }
}
