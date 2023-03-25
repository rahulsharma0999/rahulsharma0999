@extends('layouts.admin-app')
@section('title', 'Dashboard')

@section('content')


        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="{{url('admin/service-listing')}}">Service Management</a>
                          <span class="breadcrumb-item active">Service Listing</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>


              @if(Session::has('message'))
                <p class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</p>
              @endif
      
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="content table-responsive table-full-width">
                            
                            <table id="dataTableCustom" class="table table-striped custmo_data-tbl table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Service name</th>
                                <th>Price(KSh)</th>
                                <th>Duration</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($services as $service)
                            <tr>
                               <th>{{$i++}}</th>
                                <td>{{$service->service_name}}</td>
                                <td>{{$service->service_price}}</td>
                                <td>{{$service->service_duration}}</td>
                               
                             
                                <td><a href="{{url('admin/edit-service/'.$service->id)}}" class="btn btn-danger">edit</a> <a href="#blockPopup"  ui="{{$service->id}}"  data-toggle="modal" data-target="#blockPopup" class="btn btn-danger text del">delete</a> 
                            </tr>
                           @endforeach 
                              
                         
                           
                           
                        </tbody>
                    </table>
                    </div>
             
                    </div>
                </div>
                </div>
            </div>
        </div>
        @endSection
       
   @section('js_content')
    <div id="blockPopup" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
                <p>Do  you really want to delete it?</p>
                    <form id="del" action="{{url('admin/delete-service')}}" method="post">
                        {{ csrf_field() }}
                        <input id = "row_del" name = "row_del" type="hidden"  >
                    </form>
                    <button type="button" onclick="$('#del').submit()" class="btn-primary" id="modal-btn-si">Yes</button>
                    <button type="button" class="btn-danger" data-dismiss="modal">No</button>
              </div>
            </div>

          </div>
        </div>


    <script>
        $('.del').bind('click', function() {
            var i = $(this).attr('ui');
            $('#row_del').val(i);
        });
           $('#dataTableCustom').DataTable();
    </script>
    @endSection


