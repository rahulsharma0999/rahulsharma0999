@extends('layouts.admin-app')
@section('title', 'Dashboard')

@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" >User Management</a>
                          <a class="breadcrumb-item" href="{{url('admin/user-list')}}">User Listing</a>
                          <span class="breadcrumb-item active">Edit User</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management">
                    <div class="signup-wrap login-wrap change-password user-detail-ww">
							<!--<div class="user-image-ww">
                              <img src="@if(!empty($user->image)) {{$user->image}} @else {{url('admin/assets/img/user.png')}} @endif"  alt="Doggo" align="middle" class="ti-image" height="50px" width="50px">
                            </div>-->
                            <div class="create-service-ww">
                              <h1 class="main-heading">Edit User Detail</h1>
                            </div>
                            <div class="clearfix"></div>

                             @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                           <form action="{{url('admin/edit-user-detail/'.$user->id)}}" method="post" >
                               {{csrf_field()}}
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="full_name" value="{{$user->full_name}}" required>
                                           <span class="text-danger">{{$errors->first('full_name')}}</span>   
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Email
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="email" value="{{$user->email}}" required>
                                        <span class="text-danger">{{$errors->first('email')}}</span>   
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Phone
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="phone_number" value="{{$user->phone_number}}" required>
                                     <span class="text-danger">{{$errors->first('phone_number')}}</span>   
                                        </div>
                                        </li>
                               </ul>
                               <div class="form-group text-center signup-btn">
                                  <!-- <a href="javascript:void(0);" class="filled-btn">Update</a>-->
                                       <input type="submit" class="filled-btn" value="Update" >
                               </div>
                           </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>


     @endSection

   @section('js_content')

    <script>
        
    </script>
    @endSection