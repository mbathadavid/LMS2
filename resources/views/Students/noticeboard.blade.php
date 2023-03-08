@extends('layouts.layout')

@section('title','Notice Board')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Students.sidebar')
</div>
<div id="main" class="maincontent">

@include('Students.topnav')
<h5 class="">Notices</h5>
<div class="row justify-content-center align-items-center">
<div class="col-lg-8 col-md-8 col-sm-12">
@foreach($notices as $notice)
<div class="mb-3 border border-dark">
    <h6 class="w3-green p-2 text-center mb-0">{{ ucwords($notice['topic']) }}</h6>
    <p class="p-2 w3-grey mt-0 mb-0">{{ $notice['message'] }}</p>
    <div class="p-2 ">
        @if ($notice['filetype'] == NULL)
            <h6 class="text-center">No files attached</h6>
        @elseif ($notice['filetype'] == "pdf") 
            <embed src="images/{{ $notice['filename'] }}" type="application/pdf"><br>
            <h6 class="text-center text-danger"><a class="text-warning" href='{{ asset("images/$notice[filename]") }}' target="_blank">Open File in New Tab</a></h6>
        @else 
            <img class="img-fluid" src="images/{{ $notice['filename'] }}" alt="File Here">
        @endif
    </div>

    <div class="p-2 w3-red mt-0">
        <h6 class="text-center">Date: {{ $notice['created_at'] }}</h6>
        <h6 class="text-center">Send By: {{ $notice['sendername'] }}</h6>
    </div>
</div>
@endforeach
</div>
</div>
 
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        //setting csrf token
        $.ajaxSetup({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


    })
</script>
@endsection