<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
Use App\User;
use GuzzleHttp;
use Hash;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use DB;
use Session;
use Redirect;
use Carbon\Carbon;
date_default_timezone_set("UTC");
//date_default_timezone_set('Africa/Nairobi');
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);

class LocationTrackingController extends Controller
{
    public function viewLocation(Request $request)
    {
        $get_vans=DB::table('users')->where(['role'=>3])->get();  
        //dd($get_vans);     
        return view('admin.location-tracking',['vans'=>$get_vans]);
    }
    
    public function reviewDetail(Request $request ,$id)
    {
       
        $review_detail=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->leftJoin('reviews','reviews.request_id','=','requests.id')
            ->where(['requests.id'=>$id])
             ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id','reviews.*')
            ->first();
        return view('admin.review-detail',['request'=>$review_detail]);
    }


     public function updateLatLong(Request $request)
    {
       
        $get_van=DB::table('users')->where(['id'=>$request->id,'role'=>3])->first();
        $data=json_encode($get_van);
        return $data;
    }

    

    

    

}
