@extends('layouts.admin-app')
@section('title', 'Dashboard')
@section('content')
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="topBreadcrumb">                
                          <a class="breadcrumb-item" href="{{url('admin/location-tracking')}}">Location Tracking</a>
                          <span class="breadcrumb-item active">Van Location</span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="content package-management">
                            <div class="signup-wrap login-wrap change-password van-location-ww">
                             <div class="van-dropdown">
                               <label>Select van from dropdown</label>
                               <select>
                                 <option selected disabled>Select Van</option>
                                @foreach($vans as $van)
                                 <option value="{{$van->id}}">{{$van->name}}</option>
                                @endforeach   
                               </select>
                             </div>
                             <div class="van-location-map-ww">
                               <div id="maplnk">
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
$('select').on('change', function()
{
   var van_id= this.value;

    $.ajax({
        async: true,
        url: '<?php echo url('admin/update-lat-lon'); ?>'+'/'+van_id,
        method: 'GET',
        dataType: 'text',
        success: function(returnData){
          data = returnData;
          data1 = $.parseJSON(data)


        var map_data='<iframe src="https://maps.google.com/maps?q='+data1.latitude+','+data1.longitude+'&hl=es;z=14&amp;output=embed" width="100%" height="450px" frameborder="0" style="border:0" allowfullscreen></iframe>';
         $('#maplnk').html(map_data);
        }
      });

});
</script>script>
@endsection
    