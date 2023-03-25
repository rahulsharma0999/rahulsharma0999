@extends('layouts.admin-app')
@section('title', 'Payment Receive List')
@section('heading')
	 <span class="breadcrumb-item active">Payment Management</span>
@endsection
@section('content')
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
                                <th>User Name</th>
                                <th>Photographer Name</th>
                                <th>Order number</th>
                                <th>Amount</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                              <tr>
                                <td>1</td>
                                <td>John Deo</td>
                                <td>Harry</td>
                                <td>1212</td>
                                <td>$24 </td>
                                <td>
                                 <a href="{{ url('admin/view-receive-payment-detail') }}" class="btn btn-success">View</a>  </td>
                            </tr>
                             
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

   	<script>
   		
   	</script>
@endSection