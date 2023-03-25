@extends('layouts.admin-app')
@section('title', 'Add New Vehicle Type')
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
                          <a class="breadcrumb-item">Vehicle Type Management</a><!--  href="{{url('admin/vehicle-listing')}}" -->
                          <span class="breadcrumb-item active">Add New Vehicle Type</span>
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
                              <h1 class="main-heading">Add New Vehicle Type</h1>
                            </div>
                              @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                              @endif
                           <form action="{{url('admin/add-new-vehicle')}}" method="post">
                              {{csrf_field()}}
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Vehicle Type Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="type" value="{{old('type')}}" placeholder="Vehicle Type Name " required>
                                         <span class="text-danger">{{$errors->first('type')}}</span>    
                                        </div>

                                       
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Price(KSh)
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     <input type="text" name="service_price" value = "{{old('service_price')}}" placeholder="Enter Service Price" required>
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
             <input type="text" name= "service_duration"  class="" value="00:00" readonly>
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
                                          <textarea placeholder="Enter Service Description" name = "service_description" value = "{{old('service_description')}}" required></textarea>
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


  @endsection
   @section('js_content')
  <script type="text/javascript" src="{{url('admin/assets/js/bootstrap-clockpicker.min.js')}}"></script>
        <script type="text/javascript">
             $( function() {
    $( ".datepicker" ).datepicker();
  } );

$('.clockpicker').clockpicker();
</script>

    @endSection
