
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
                          <span class="breadcrumb-item active">User Detail</span>
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
                              <img src="@if(!empty($user->image)) {{$user->image}} @else {{url('admin/assets/img/user.png')}} @endif" alt="">
                            </div>-->
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$user->full_name}}</span>
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Email
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$user->email}}</span>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Phone
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <span>{{$user->phone_number}}</span>
                                        </div>
                                        </li>
                               </ul>
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

