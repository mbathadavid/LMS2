@extends('layouts.layout')

@section('title','Notifications')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')

<div class="row justify-content-center align-item-center">
    <div id="accountupdatedivres"></div>

    <div class="col-lg-6 col-md-8 col-sm-12">
    <table class="table" id="notificationstable">
            <thead>
            <tr class="">
                <th scope="col">Type</th>
                <th scope="col">Notification Text</th>
                <th scope="col">Has attached files?</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>  
            </tr>
        </thead>
        <tbody id="notificationstablebody">
            
        </tbody>
        </table>
        </div>

</div>
    
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
function preview(){
    chosenprof.src=URL.createObjectURL(event.target.files[0]);
}
</script>

<script>
$(document).ready(function(){
    //set csrf
    fetchnotifications();

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        function fetchnotifications() {
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchadminotifications/${sid}`,
                //dataType: 'jsons',
                success: function(res) {
                    console.log(res);
                    if (res.notifications.length == 0) {
                        $('#notificationstablebody').html('<h5 class="text-center text-danger">No any parents registered as at now</h5>');
                    } else {
                        $('#notificationstablebody').html('');
                         $.each(res.notifications, function(key,item){
                            $('#notificationstablebody').append('<tr class="'+(item.type == "parentmessage" ? "w3-grey" : "")+'">\
                                <td>'+(item.type == "noticeboard" ? "Notice" : "Parent's Message")+'</td>\
                                <td>'+item.noficationtxt+'</td>\
                                <td>'+(item.filename == null ? "No" : "Yes")+'</td>\
                                <td>'+item.created_at+'</td>\
                                <td>Action</td>\
                            </tr>')
                    }); 

                        $("#notificationstable").DataTable().fnDestroy()

                        $('#notificationstable').DataTable({
                            ordering: false,
                            paging: false,
                            searching: true
                         });

                    }  
                }
            })          
        }
    
})
</script>
@endsection