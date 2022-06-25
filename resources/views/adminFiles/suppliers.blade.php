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
<h1 class="text-center text-danger">Suppliers Staff here</h1>
    
</div>
</div>
</div>
@endsection 
@endif


@section('script')

@endsection