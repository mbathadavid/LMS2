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
@include('Parents.sidebar')
</div>
<div id="main" class="maincontent">
@include('Parents.topnav')
<h6>Notifications</h6>
<div class="row justify-content-center align-item-center">
<div class="col-lg-8 col-md-8 col-sm-12">
    <div class="table-responsive">
    <table class="table" id="notificationstable">
            <thead>
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Notification Text</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>  
            </tr>
        </thead>
        <tbody id="notificationstablebody">
            @foreach($notifications as $notification)
                <tr class="{{ $notification['type'] == "noticeboard" ? "w3-grey" : "w3-green" }}">
                    <td>{{ $notification['type'] == "noticeboard" ? "Notice to all Parents" : "Reply to your Message" }}</td>
                    <td>{{ $notification['noficationtxt'] }}</td>
                    <td>{{ $notification['created_at'] }}</td>
                    <td><a href='{{ $notification['type'] == "noticeboard" ? route('parent.noticeboard') : route('parent.mymessages') }}' class="btn btn-sm w3-red"><i class="fas fa-eye"></i>&nbsp; View</a></td>
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
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    
})
</script>
@endsection