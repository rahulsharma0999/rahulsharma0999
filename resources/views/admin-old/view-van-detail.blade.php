@extends('layouts.admin-app')
@section('title', 'Dashboard')
@section('content')
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="{{url('admin/service-van-listing')}}">Service Van Management</a>
                          <span class="breadcrumb-item active">Van Detail</span>
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
                              <h1 class="main-heading">View Van Detail</h1>
                            </div>
                           <form action="">
                               <ul>
                                      <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Van Name
                                   </label>
                                       </div>
                                        <div class="sign-up-right padding-added">
                                     <span>{{$van->name}}</span>
                                        </div>
                                   </li>
                                    <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Van Number
                                   </label>
                                       </div>
                                        <div class="sign-up-right padding-added">
                                     <span>{{$van->number}}</span>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Van Email
                                   </label>
                                       </div>
                                        <div class="sign-up-right padding-added">
                                     <span>{{$van->email}}</span>
                                        </div>
                                        </li>
                                        <li>
                                       <div class="sign-up-left">
                                            <label>
                                       Van License Plate Number
                                   </label>
                                       </div>
                                        <div class="sign-up-right padding-added">
                                     <span>{{$van->license_plate_no}}</span>
                                        </div>
                                        </li>
                               </ul>
                           </form>
                    </div>
                    </div>
                    <div class="van-detail-table-ww">
                    <h1 class="main-heading">Crew Listing</h1>
                    <div class="content table-responsive table-full-width">
                            
                            <table id="dataTableCustom" class="dataTable table table-striped custmo_data-tbl table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="sorting_asc">Sr No.</th>
                                <th class="sorting">Crew Member Name</th>
                        <th class="sorting">Contact Number</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                          @foreach($crew_members as $crew_member)
                              <tr>
                                <td>{{$i++}}</td>
                                <td>{{$crew_member->name}}</td>
                                <td>{{$crew_member->phone_number}}</td>
                            </tr>
                          @endforeach  
                        </tbody>
                    </table>
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



