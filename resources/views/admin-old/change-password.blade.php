@extends('layouts.admin-app')
@section('title', 'Edit service')

@section('content')
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="#">My Profile</a>
                          <span class="breadcrumb-item active">Change Password</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management">
                            <div class="signup-wrap login-wrap change-password">
                                @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                            <h1 class="main-heading">Change Password</h1>
                           <form action="{{url('admin/change-password')}}" method="post">

                            {{csrf_field()}}
                            @if ($errors->any())
                            <div class="alert alert-danger">
                              <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                              </ul>
                            </div>
                            @endif
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Old Password
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="Password" name="old_password" required>
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       New Password
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="Password" name="new_password"  required>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Confirm Password
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="Password" name="confirm_password" required>
                                        </div>
                                        </li>
                               </ul>
                               <div class="form-group text-center signup-btn">
                                   <input type="submit" class="filled-btn" value="Update">
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
