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
//date_default_timezone_set('Africa/Nairobi');
date_default_timezone_set("UTC");
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);

class ReviewsManagementController extends Controller
{
    public function reviewsListing(Request $request)
    {
        $get_reviews=DB::table('reviews')
      //  ->select('')
           ->leftJoin('users','users.id','=','reviews.user_id') 
           ->leftJoin('requests','requests.id','=','reviews.request_id')
           ->select('users.*','reviews.*','reviews.id as review_id','requests.*','requests.id as request_id')
           ->orderby('reviews.id','Desc')
           ->get();
		  //echo "<pre>";print_r($get_reviews);die;
        return view('admin.reviews',['reviews'=>$get_reviews]);
    }
    
    public function reviewDetail(Request $request,$request_id)
    {
       
        $review_detail=DB::table('requests')
            ->leftJoin('users','users.id','=','requests.user_id')
            ->leftJoin('services','services.id','=','requests.service_id')
            ->leftJoin('vehicles','vehicles.id','=','requests.vehicle_id')
            ->leftJoin('reviews','reviews.request_id','=','requests.id')
           ->where(['requests.id'=>$request_id])
             ->select('users.*','services.*','vehicles.*','vehicles.name as vehicle_name','requests.*','requests.id as request_id','reviews.*')
            ->first();
		//	echo "<pre>";print_r($review_detail);die;
        return view('admin.review-detail',['request'=>$review_detail]);

    }

    

    

    

}
