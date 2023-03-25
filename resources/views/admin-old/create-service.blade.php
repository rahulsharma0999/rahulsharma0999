@extends('layouts.admin-app')
@section('title', 'Users listing')

@section('content')
<style type="text/css">
.clockpicker {
    position: relative;
} 
.clockpicker span.input-group-addon {
       position: absolute;
    top: 1px;
    bottom: 0;
    margin: auto;
    right: 15px;
    border: 0;
    background: transparent;
    line-height: 24px;

}

.clockpicker  input.form-control {
    cursor: pointer;
}
</style>


        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="{{url('admin/service-listing')}}">Service Management</a>
                          <span class="breadcrumb-item active">Create Service</span>
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
                              <h1 class="main-heading">Create Service</h1>
                            </div>
                             @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                           <form action="{{url('admin/create-service')}}" method="post">
                            {{csrf_field()}}
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="service_name" placeholder="Enter Service Name" required>
                                      <span class="text-danger">{{$errors->first('service_name')}}</span>   
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Price(KSh)
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="service_price" placeholder="Enter Service Price" required>
                                      <span class="text-danger">{{$errors->first('service_price')}}</span>   
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Duration
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                    <div class="time">
    <div class="clockpicker" data-placement="left" data-align="top" data-autoclose="true">
             <input type="text" name= "service_duration" class="" value="00:00">
        <span class="input-group-addon">
                 <span class="glyphicon glyphicon-time"></span>
                 </span>
                    </div> 
</div>
                                      <span class="text-danger">{{$errors->first('service_duration')}}</span>   
                                        </div>
                                        </li>
                                           <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Description
                                   </label>
                                       </div>
                                        <div class="sign-up-right text_new">
                                          <textarea placeholder="Enter Service Description" name = "service_description" required></textarea>
                                      <span class="text-danger">{{$errors->first('service_description')}}</span>   
                                        </div>
                                        </li>
                               </ul>
                               <div class="form-group text-center signup-btn">
                                 
                                 <input type="Submit"  class="filled-btn" value="Submit">
                               </div>
                           </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
@endSection

   @section('js_content')
  <script type="text/javascript" src="{{url('admin/assets/js/bootstrap-clockpicker.min.js')}}"></script>
        <script type="text/javascript">
             $( function() {
    $( ".datepicker" ).datepicker();
  } );

$('.clockpicker').clockpicker();
</script>

    @endSection

    