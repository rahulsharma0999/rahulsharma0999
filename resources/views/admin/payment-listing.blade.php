@extends('layouts.admin-app')
@section('title', 'Car Payment')
@section('content')
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item">Payment Management</a><!--  href="{{url('admin/payment-listing')}}" -->
                          <span class="breadcrumb-item active">Car Payment</span>
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
                                <th>Booking ID</th>
                               <!--  <th>Service Name</th> -->
                                <th>Amount(KSh)</th>
                                <th>User Name</th>
                                <th>Payment Status </th>       
                            
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php($i=1)
                         @foreach($payments as $payment)
                              <tr>
                                <td>{{$i++}}</td>
                                <td>@if(!empty($payment->request_id)){{$payment->request_id}} @else N/A @endif</td>
                                <!-- <td>{{$payment->request_detail->service_name}}</td> -->
                                <td>@if(!empty($payment->amount)){{$payment->amount}} @else N/A @endif</td>
                                <td>@if(!empty($payment->request_detail->full_name)){{$payment->request_detail->full_name}} @else N/A @endif</td>
                                <td>@if($payment->payment_status=='1')Pending @elseif($payment->payment_status=='2')Confirm  @else rejected @endif</td>
                                <td>
                              <a href="{{url('admin/payment-detail/'.$payment->id)}}" class="btn btn-danger">View</a>  </td>
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