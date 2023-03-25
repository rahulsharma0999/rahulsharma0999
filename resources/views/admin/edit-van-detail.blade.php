@extends('layouts.admin-app')
@section('title', 'Edit Van')
@section('content')

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" >Service Van Management</a>
                          <a class="breadcrumb-item" href="{{url('admin/service-van-listing')}}">Van Listing</a>
                          <span class="breadcrumb-item active">Edit Van</span>
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
                            <div class="create-service-ww">
                              <h1 class="main-heading">Edit Van Detail</h1>
                            </div>
                             @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                           <form action="{{url('admin/edit-van-detail/'.$van->id)}}" method="post">
                            {{csrf_field()}}
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Van Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="van_name" value="{{$van->name}}" placeholder="Van Name" required>
                                      <span class="text-danger">{{$errors->first('van_name')}}</span>    
                                        </div>
                                   </li>
                                   <!-- <li>
                                      
                                       <div class="sign-up-left">
                                            <label>
                                       Van Number
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="number" value="{{$van->number}}" placeholder="Enter Van Number" required>
                                         <span class="text-danger">{{$errors->first('number')}}</span>    
                                        </div>
                                        </li> -->
                                        <li> 
                                       <div class="sign-up-left">
                                            <label>
                                       Van Email
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text"  name="email" value="{{$van->email}}" placeholder="Enter Van Email" required>
                                       <span class="text-danger">{{$errors->first('email')}}</span> 
                                       </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Van License Plate Number
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="license_plate_no" value="{{$van->license_plate_no}}" placeholder="Enter Van License Plate Number" required>
                                       <span class="text-danger">{{$errors->first('license_plate_no')}}</span>  
                                        </div>
                                        </li>
                               </ul>
                               <div class="form-group text-center signup-btn">
                                
                                   <input type="submit" class="filled-btn" value="Submit">

                               </div>
                           </form>
                           
                    </div>
                    </div>
                </div>
            </div>
        </div>
 @endsection       


  