@extends('layouts.admin-app')
@section('title', 'Dashboard')

@section('content')

   <div class="content dashBoard">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="content">
                                <a href="{{url('admin/user-list')}}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 footer text-center">
                                        <div class="numbers stats">
                                            <p>User Management</p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="content">
                                <a href="{{url('admin/service-listing')}}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-car"></i>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 footer text-center">
                                        <div class="numbers stats">
                                            <p>Service Management</p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="content">
                               <a href="{{url('admin/request-listing')}}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-envelope-square"></i>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 footer text-center">
                                        <div class="numbers stats">
                                            <p>Request Management</p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="content">
                                <a href="{{url('admin/payment-listing')}}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 footer text-center">
                                        <div class="numbers stats">
                                            <p>Payment Management</p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="content">
                                <a href="{{url('admin/service-van-listing')}}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-bus"></i>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 footer text-center">
                                        <div class="numbers stats">
                                            <p>Service Van Management</p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <div class="content">
                              <a href="{{url('admin/location-tracking')}}">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="icon-big text-center">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-xs-12 footer text-center">
                                        <div class="numbers stats">
                                            <p>Location Tracking</p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
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