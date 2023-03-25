@extends('layouts.admin-app')
@section('title', 'Carpet Price')
@section('content')
<style type="text/css">
.d-flex {
        display: flex;
        margin-left: 30px;
         margin-top: 15px;
    }
    .ser_req_btn {
        margin-right: 12px;
    }
.past_btn .filled-btn {
        background-color: transparent;
        color: #000000;
    }
    .past_btn .filled-btn:hover {
        color: #fff;
    }
</style>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item">Service Management</a>
                          <span class="breadcrumb-item active">Carpet Price</span>
                        </nav>
                    </div>
                </div>
            </div>


            <div class="d-flex">
                 <div class="ser_req_btn past_btn">
                    <a class="" href="{{url('admin/carpet-measurement-list')}}">
                        <input type="submit" class="filled-btn" value="Carpet Measurement List">
                    </a>
                </div>
                <div class="ser_req_btn past_btn">
                    <a class="" href="{{url('admin/carpet-measurement')}}">
                        <input type="submit" class="filled-btn" value="Carpet Measurement">
                    </a>
                </div>
                <div class="ser_req_btn">
                    <a class="" href="{{url('admin/carpet-service')}}">
                        <input type="submit" class="filled-btn" value="Carpet Price">
                    </a>
                </div>
            </div>


        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management">
                            <div class="signup-wrap login-wrap change-password user-detail-ww">
                            <div class="create-service-ww">
                              <h1 class="main-heading">Add Carpet Price</h1>
                            </div>
                              @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                           <!-- <form action="{{url('admin/add-new-vehicle')}}" method="post"> -->
                            <form method="post">
                              {{csrf_field()}}


                            <ul>   
                                <div class="sign-up-left">
                                  <label style="display: contents">
                                       Price Per Square feet (KSh)  
                                  </label>
                                </div>
                                <div class="sign-up-right">
                                    <input type="text" maxlength="10" name="amount_per_square" value="{{$data->amount_per_square ?? ""}}" placeholder="Price " autocomplete="off" >
                                  <span class="text-danger">{{$errors->first('amount_per_square')}}</span>    
                                </div> 
                            </ul>


                            @if (!empty($data->amount_per_square)) 
                               <div class="form-group text-center signup-btn">
                                   <input type="Submit"  class="filled-btn" value="Update">
                               </div>
                            @else
                               <div class="form-group text-center signup-btn">
                                   <input type="Submit"  class="filled-btn" value="Submit">
                               </div>
                            @endif
                           </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>


  @endsection
   @section('js_content')


    @endSection
