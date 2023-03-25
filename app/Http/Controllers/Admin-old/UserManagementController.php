<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use Illuminate\Validation\Rule;

use App\User;
use DataTables;
use DB;
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
class UserManagementController extends Controller
{

     public function usersList(Request $request)
    {
      $users = User::where(['status'=>1, 'role'=>2])->orderBy('id','DESC')->get();
        return view('admin.user-list',['users'=>$users]);
       
    }
    public function userListPagination(Request $request)
    {
        
         if ($request->ajax()) {
           $query = User::select('id','full_name','email')
                                ->where(['status'=>1, 'role'=>2])
                                ->orderBy('id','DESC')
                                ->get();
            foreach ($query as $key => $value) {
                $value->sr = $key+1;              
            }
           
            return DataTables::of($query)
                ->addColumn('action', function ($query) {
                        return '<a href="'.url("super-admin/view-user/".$query->id).'" class="primary-btn">View</a>|<a href="'.url("super-admin/edit-user/".$query->id).'" class="primary-btn">Edit</a>|<a style="cursor:pointer;" onclick="return confirm(\'Are you sure you want to delete this User?\');" href="'.url("super-admin/delete-user/".$query->id).'" class="primary-btn">Delete</a>';
                        })
                ->make(true);
        }
       
    }

    public function viewUserDetail(Request $request)
    {
    	$users = User::where(['role'=>2,'id'=>$request->value])->first();
        
        return view('admin.view-user-detail',['user'=>$users]);
    }

    public function blockUserAction(Request $request)
    {
        $users = User::where(['id'=>$request->value])->first();
        if($users->block_status == 1){
    	   $users = User::where(['id'=>$request->value])->update(['block_status'=>2]);
            Session::flash('message','User unblocked successfully.');
        }else{
            $users = User::where(['id'=>$request->value])->update(['block_status'=>1]);
            Session::flash('message','User blocked successfully.');
        }
        return redirect('admin/user-list');
       
    }

    public function deleteUser(Request $request)
    {
    	
        $users = User::where(['id'=>$request->row_del])->delete();
        Session::flash('message','User deleted successfully.');
        return redirect('admin/user-list');
        
    }

    public function editUserDetail(Request $request)
    {
    	
        $users = User::where(['role'=>2,'id'=>$request->value])->first();

        if($request->isMethod('post')){
            $errors = array('full_name.required'=>'Please enter your full name',
            'email.required'=>'Please enter your email address',
            'email.unique:users,email'=>'Email already registered',
            //'image.image:jpg,png'=>'Please select only JPG or PNG image',
            'password.min:6'=>'Password must be minimum 6 characters',
            'confirm_password.same:password'=>'Password and confirm password does not match ',
            );
            $validator = Validator::make($request->all(), [
                    'full_name' => 'required|regex:/^[\pL\s\-]+$/u|max:30',
                    'email' => 'required|email|unique:users,email,'.$request->value,
                    'phone_number' => 'required|numeric|digits_between:8,15',
                    'image' =>  'mimes:jpeg,png,jpg',           
            ], $errors);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            $update_data['full_name']=$request->full_name;
            $update_data['email']=$request->email;
            $update_data['phone_number']=$request->phone_number;
            DB::table('users')->where('id',$request->value)->update($update_data);
            Session::flash('message','User detail updated successfully');
            return Redirect('admin/user-list');
        }
        return view('admin.edit-user-detail',['user'=>$users]);
    }

    public function photographerListPagination()
    {
    }

    public function viewPhotographerDetail()
    {
    	return view('admin/view-photographer-detail');
    }

    public function blockPhotographerAction()
    {
    	return view('admin/photographer-list');
    }

    public function deletePhotographer()
    {
    	return view('admin/photographer-list');
    }

    public function editPhotographerDetail()
    {
    	return view('admin/edit-photographer-detail');
    }

}
