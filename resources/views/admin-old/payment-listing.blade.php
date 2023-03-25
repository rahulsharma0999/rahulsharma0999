@extends('layouts.admin-app')
@section('title', 'Dashboard')
@section('content')
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="{{url('admin/payment-listing')}}">Payment Management</a>
                          <span class="breadcrumb-item active">Payment Received</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content table-responsive table-full-width">
                            <table id="dataTableCustom" class="table table-striped custmo_data-tbl review-management table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Booking id</th>
                                <th>Service Name</th>
                                <th>Amount</th>
                                <th>User name</th>
                                        

                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                         @foreach($payments as $payment)
                              <tr>
                                <td>{{$i++}}</td>
                                <td>15001</td>
                                <td>{{$payment->request_detail->service_name}}</td>
                                <td>&#36;100</td>
                                <td>{{$payment->request_detail->full_name}} </td>
                                <td>
                              <a href="{{url('admin/payment-detail/'.$payment->request_detail->id)}}" class="btn btn-danger">View</a>  </td>
                        @endforeach
                        </tbody>
                    </table>
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