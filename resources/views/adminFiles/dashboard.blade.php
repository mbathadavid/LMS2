@extends('layouts.layout')

@section('title','DashBoard')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">
@include('adminFiles.motto')
<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')

<!-- <a href="/downloadtranscript">Download Transcript</a>
<iframe src="http://127.0.0.1:8000/getparentspdf" frameborder="0" style="background-color: grey;width: 50%;float: right;height:100%">

</iframe> -->

{{ session()->get('LoggedInUser.Email') }}

{{ session()->get('schooldetails.name') }}
    
</div>
</div>
</div>
@endsection 
@endif


@section('script')

@endsection