<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advertisement;
use Validator;
use Session;

header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);

class AdvertisementController extends Controller
{
    public function addAdvertisement(Request $request){

    	if($request->isMethod('GET')){
	    	return view("admin.add-advertisement");
	    }
	    if($request->isMethod('POST')){
 			

 			$errors = array(
            'title.required'=>'Please enter title.', 
            'title.min'=>'Title should be at least 2 character long.', 

            'link.required'=>'Please enter link.', 
            'link.min'=>'Link should be at least 2 character long.', 

            'image.required'=>'Please upload image.', 

            );
            $validator = Validator::make($request->all(), [
             'title' => 'required|min:2',
             // 'link' => 'required|min:2',
            'link' => 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',

             // 'link' => 'required|url',
             'image' => 'required',


                  
            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $link_value = $request->link;

            if (str_contains($link_value, '.com')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.co')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.in')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.net')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.org')) { 
                echo 'true';
            }else{
                return back()->with("error" , "Please enter valid link extension.");
            }



            $remove = "http://";
            $remove1 = "https://";


            if (strpos($link_value, $remove) !== false) { 
                $final_link = trim($link_value,$remove); 
                $data['title'] = $request->title;
                $data['link']  = "http".'://'.$final_link;
            }
            else if (strpos($link_value, $remove1) !== false) { 
                $final_link = trim($link_value,$remove1); 
                $data['title'] = $request->title;
                $data['link']  = "https".'://'.$final_link;
            }
            else{
                $final_link = $link_value;
                $data['title'] = $request->title;
                $data['link']  = "https".'://' .$final_link;
            }


 
	    	if($request->hasFile('image')) {
               $file = $request->file('image');
               $filename = time() . '.' . $file->getClientOriginalExtension();
               // $file->move(storage_path()."/".env('CATEGORY_PATH'), $filename);
               $file->move(storage_path(). DIRECTORY_SEPARATOR . "app/public/advertisement_images" , $filename);
               $data["image"] = $filename;
            }

            $is_created = Advertisement::create($data);

            if($is_created){
            	return redirect("admin/advertisement-listing")->with("message" , "Advertisement added successfully.");
            }else{
            	return back()->with("error" , "Unable to add Advertisement.");
            }
	    }
	}


	public function advertisementListing(Request $request){
		$data = Advertisement::orderBy("id" , "Desc")->get();
		return view("admin/advertisement-listing" , compact("data"));
	}




	public function editAdvertisement(Request $request , $id){

    	if($request->isMethod('GET')){
    		$data = Advertisement::where("id" , $id)->first();
	    	return view("admin.edit-advertisement" , compact("data"));
	    }
	    if($request->isMethod('POST')){
 			

 			$errors = array(
            'title.required'=>'Please enter title.', 
            'title.min'=>'Title should be at least 2 character long.', 

            'link.required'=>'Please enter link.', 
            'link.min'=>'Link should be at least 2 character long.', 
            // 'link.url'=>'Please enter valid url.', 

            );
            $validator = Validator::make($request->all(), [
             'title' => 'required|min:2',
             // 'link' => 'required|min:2|url',
            'link' => 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
             

                  
            ],$errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

	    	$link_value = $request->link;



            if (str_contains($link_value, '.com')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.co')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.in')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.org')) { 
                echo 'true';
            }
            else if (str_contains($link_value, '.net')) { 
                echo 'true';
            }else{
                return back()->with("error" , "Please enter valid link extension.");
            }



            $remove = "http://";
            $remove1 = "https://";


            if (strpos($link_value, $remove) !== false) { 
                $final_link = trim($link_value,$remove); 
                $data['title'] = $request->title;
                $data['link']  = "http".'://'.$final_link;
            }
            else if (strpos($link_value, $remove1) !== false) { 
                $final_link = trim($link_value,$remove1); 
                $data['title'] = $request->title;
                $data['link']  = "https".'://'.$final_link;
            }
            else{
                $final_link = $link_value;
                $data['title'] = $request->title;
                $data['link']  = "https".'://' .$final_link;
            }


            
 
            if($request->hasFile('image')) {
               $file = $request->file('image');
               $filename = time() . '.' . $file->getClientOriginalExtension();
               // $file->move(storage_path()."/".env('CATEGORY_PATH'), $filename);
               $file->move(storage_path(). DIRECTORY_SEPARATOR . "app/public/advertisement_images" , $filename);
               $data["image"] = $filename;
            }

            $is_updated = Advertisement::where("id" , $id)->update($data);

            if($is_updated){
                Session::flash('message','Advertisement updated successfully');
                return Redirect('admin/advertisement-listing');
            	// return redirect("admin/advertisement-listing")->with("message" , "Advertisement updated successfully.");
            }else{
            	// return back()->with("error" , "Unable to update Advertisement.");
                Session::flash('message','Unable to update Advertisement');
                return Redirect('admin/advertisement-listing');
            }
	    }
	}



	public function deleteAdvertisement(Request $request){
		Advertisement::where("id" , $request->id)->delete(); 

        Session::flash('message','Advertisement deleted successfully.');
        return redirect('admin/advertisement-listing');

		// return redirect("admin/advertisement-listing")->with("message" , "Advertisement deleted successfully.");
	}





}
