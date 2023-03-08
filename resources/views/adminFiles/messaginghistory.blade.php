@extends('layouts.layout')

@section('title','Messaging History')

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

    <div class="col-lg-10 col-md-10 col-sm-12">
    <div class="table-responsive">
    <table class="table" id="messagestable">
            <thead>
            <tr class="w3-green">
                <th scope="col">Message</th>
                <th scope="col">Sender</th>
                <th scope="col">Recipient</th>
                <th scope="col">Cost (Ksh.)</th>
                <th scope="col">Status</th>
                <th scope="col">API Used</th>
                <th scope="col">Date Send</th>  
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
                url: `/fetchmessaginghistory/${sid}`,
                //dataType: 'jsons',
                success: function(res) {
                    //console.log(res);
                    if (res.messaginghistory.length == 0) {
                        $('#notificationstablebody').html('<h5 class="text-center text-danger">No any notifications yet.</h5>');
                    } else {
                        $('#notificationstablebody').html('');
                         $.each(res.messaginghistory, function(key,item){
                            $('#notificationstablebody').append('<tr>\
                                <td>'+item.message+'</td>\
                                <td>'+(item.senderid == "{{ session()->get('LoggedInUser.id') }}" ? "Me" : item.sender_name)+'</td>\
                                <td>'+item.number+'</td>\
                                <td>'+item.message_cost+'</td>\
                                <td class="'+(item.status == "Send Successfully" ? "text-success" : "text-danger")+'"><b>'+(item.status == "Send Successfully" ? item.status : "Failed ("+item.Description+")")+'</b></td>\
                                <td>'+item.API_used+'</td>\
                                <td>'+item.created_at+'</td>\
                            </tr>')
                    }); 

                        // $("#messagestable").DataTable().fnDestroy()

                        // $('#messagestable').DataTable({
                        //     ordering: true,
                        //     paging: true,
                        //     //searching: true
                        //  });
                    }  
                }
            })          
        }
    
})
</script>
@endsection