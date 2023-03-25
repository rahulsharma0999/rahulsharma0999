@extends('layouts.admin-app')
@section('title', 'Vehicle Type Detail')
@section('content')
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">      
                          <a class="breadcrumb-item"> Vehicle Type Management</a>          
                          <a class="breadcrumb-item" href="{{url('admin/vehicle-listing')}}"> Vehicle Type Listing</a>
                          <span class="breadcrumb-item active">Vehicle Type Detail</span>
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
                              <h1 class="main-heading">View Vehicle Type Detail</h1>
                            </div>
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Vehicle Type Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right padding-added">
                                     <span>{{$van->type}}</span>
                                        </div>
                                   </li>
                                  <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Price(KSh)
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                     
                                      <span >{{$service->service_price}}</span>   
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Duration
                                   </label>
                                       </div>
                                        <div class="sign-up-right">
                                   
                                        <span>{{$service->service_duration}}</span>
                 
                                       </div> 

                                   </li>
                                   <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Service Description
                                   </label>
                                       </div>
                                        <div class="sign-up-right text_new">
                                          <textarea disabled >{{$service->description}}</textarea>
                                      <span></span>   
                                        </div>
                                        </li>
                                     
                               </ul>
                           </form>
                    </div>
                    </div>
                
                </div>
            </div>
        </div>
@endsection        
  @section('js_content')
  <script type="text/javascript">
       
     $('#dataTableCustom').DataTable();


  
   </script>
  @endsection    



