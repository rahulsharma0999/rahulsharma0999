@extends('layouts.admin-app')
@section('title', 'Carpet Service Request')

@section('content')
<style>
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
    .content.table-responsive .custmo_data-tbl td a.btn + a.btn {
    margin-left: 0;
}
</style>
<?php //dd($requests); ?>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item">Request Management</a><!--  href="{{url('admin/request-listing')}}" -->
                          <span class="breadcrumb-item active">Carpet Service Request</span>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <div class="ser_req_btn">
                    <a class="" href="{{url('admin/carpet-new-list')}}">
                        <input type="submit" class="filled-btn" value="New Carpet Request">
                    </a>
                </div>
                <div class="ser_req_btn past_btn">
                    <a class="" href="{{url('admin/carpet-past-list')}}">
                        <input type="submit" class="filled-btn" value="Past Carpet Request">
                    </a>
                </div>
            </div>
            
        </section>


        <div class="content">
            <div class="container-fluid">
                @if(Session::has('message'))
                            <p class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</p>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                           
                            <div class="content table-responsive table-full-width">
                            
                            <table id="dataTableCustom" class="table table-striped custmo_data-tbl table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Service Name</th>
                                <th>Carpet Length</th>
                                <th>Carpet Width</th>
                                <th>Amount(KSh)</th>
                                <th style="width: 0.889px;">Address</th>
                                <th>Service Date & Time </th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                         @foreach($data as $data) 
                              <tr>
                               <th>{{$i++}}</th>
                                <td><!-- {{$data->full_name}} -->Carpet </td>
                                <td>{{$data->length}}</td>
                                <td>{{$data->width}}</td>
                                <td>{{$data->amount}}</td>
                                <td>{{$data->address}}</td>
                                <td>{{date('d-m-Y',strtotime($data->date)).' '.$data->time}}</td>
                                
                                 <!-- <td><a href="{{url("admin/request-carpet-detail").'/'.($data->id) }}" class="btn btn-danger">view</a> 
                                 <a href="#blockPopup"  ui="{{$data->id}}"  data-toggle="modal" data-target="#blockPopup" class="btn btn-danger text del">delete</a> -->

                                <td><a href="{{url('admin/request-new-carpet-detail/'.$data->id)}}" class="btn btn-danger">view</a> 
                                 <a href="#blockPopup"  ui="{{$data->id}}"  data-toggle="modal" data-target="#blockPopup" class="btn btn-danger text del">delete</a>

                               
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
                    <form id="del" action="{{url('admin/delete-new-carpet-request/'.'*')}}" method="post">
                        {{ csrf_field() }}
                        <input id = "row_del" name = "request_id" type="hidden"  >
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
