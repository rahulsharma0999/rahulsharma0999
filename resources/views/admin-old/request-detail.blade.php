@extends('layouts.admin-app')
@section('title', 'Dashboard')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <nav class="topBreadcrumb">                
                      <a class="breadcrumb-item" href="{{url('admin/request-listing')}}">Request Management</a>
                      <span class="breadcrumb-item active">Request Detail</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="content package-management clearfix">
                        <div class="signup-wrap login-wrap change-password user-detail-ww request-detail-ww clearfix">
                        <div class="col-sm-6">
                        <div class="service-detail">
                        <h1 class="main-heading">Service Detail</h1>
                       <form action="">
                           <ul>
                                  <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Service Name
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->service_name}}</span>
                                    </div>
                               </li>
                                <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Service Date
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{date('d-m-Y',strtotime($request->service_date))}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Service  Time
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{ date('h:i A', strtotime($request->service_time))  }}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                  <label>
                                   Total Time
                                  </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->service_duration}} Hours</span>
                                    </div>
                                    </li>
                                     <li>
                                   <div class="sign-up-left">
                                  <label>
                                   Total Amount(KSh)
                                  </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->total_price}}</span>
                                    </div>
                                    </li>
                           </ul>
                       </form>
                       </div>
                       </div>

                       <div class="col-sm-6">
                       <h1 class="main-heading">Add On Services</h1>
                       <form action="">
                           <ul>
                                  
                               @foreach($add_on_services as $add_on_service)

                                  <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Service Name
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$add_on_service->service_name}}</span>
                                    </div>
                               </li>

                               <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Service Price(KSh)
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$add_on_service->service_price}}</span>
                                    </div>
                               </li>

                               <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Service Duration
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$add_on_service->service_duration}}</span>
                                    </div>
                               </li>
                               @endforeach

                                
                                   
                                    
                           </ul>
                       </form>
                       </div>
                       <div class="col-sm-6">
                       <h1 class="main-heading">User Detail</h1>
                       <form action="">
                           <ul>
                                  <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Full Name
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->full_name}}</span>
                                    </div>
                               </li>
                                <li>
                                   <div class="sign-up-left">
                                        <label>
                                  Phone 
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->phone_number}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Email
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->email}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Address
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->service_address}} </span>
                                    </div>
                                    </li>
                           </ul>
                       </form>
                       </div>
                       <div class="col-sm-12">
                       <h1 class="main-heading">Vehicle Detail</h1>
                       <form action="">
                           <ul>
                                  <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Vehicle name
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->vehicle_name}}</span>
                                    </div>
                               </li>
                                <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Brand
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->brand}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Type
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->type}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   Colour
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->colour}}</span>
                                    </div>
                                    </li>
                                    <li>
                                   <div class="sign-up-left">
                                        <label>
                                   License plate number
                               </label>
                                   </div>
                                    <div class="sign-up-right">
                                 <span>{{$request->license_plate_no}}</span>
                                    </div>
                                    </li>
                           </ul>
                       </form>
                       </div>
                       <div class="col-sm-12">
                        
                         <div class="content table-responsive table-full-width">
                          
                        
                        <table id="dataTableCustom" class="table table-striped custmo_data-tbl table-bordered" style="width:100%">

                    <thead>
                        <tr>
                            <th class="sorting_asc">Sr No.</th>
                            <th class="sorting_asc">Van Name</th>
                            <th class="sorting_asc">Van ID</th>
                            <th class="sorting_asc">Van Email</th>
                            <th class="sorting_asc">Van license plate number</th>
                            <th class="sorting_asc">Distance</th>
                            <th>Select Van</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php($i=1)
                      @foreach($service_vans as $service_van)
                          <tr>
                            <td>{{$i++}}</td>
                            <td>{{$service_van->name}}</td>
                            <td>{{$service_van->number}}</td>
                            <td>{{$service_van->email}}</td>
                         	<td>{{$service_van->license_plate_no}}</td>
                            <td>{{$service_van->distance}} Miles</td>

                            <td><input class="del" type="radio" value="{{$service_van->id}}"  ui="{{$service_van->id}}" <?php if($service_van->id == $request->van_id) echo 'checked'; ?>   name="van">
                             

                            </td>
                        </tr>
                        @endforeach
                         
                    </tbody>
                </table>
                </div>
                <div class="form-group login-btn">
                           <form action ="{{url('admin/accept-request')}}" method="post" id="form1">
                            <input type="hidden" name="request_id" value="{{$request->id}}">
                            {{csrf_field()}}
                            <input type="hidden" name="van_id" id="van_id">
                            @if($request->request_status == 1)
                            <button type="submit" form="form1" class="filled-btn" value="Submit">Accept Request</button>
                            <a href="{{url('admin/delete-request/'.$request->id)}}" class="filled-btn">Decline Request</a>
                            @endif
                          </form>
                           
                        </div>
                       </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_content')
    
    <script>
        $('.del').bind('click', function(){
            var i = $(this).attr('ui');
          
            $('#van_id').val(i);
        });
     
    $('#form1').submit(function() {
      if($('#van_id').val()==0){
        alert('Please select Van');
        return false;
      }
    });

     $('#dataTableCustom').DataTable();
    </script>
    @endSection
   