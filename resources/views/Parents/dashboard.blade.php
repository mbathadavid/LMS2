@extends('layouts.layout')

@section('title','DashBoard')

@section('content')
    
    
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Parents.sidebar')
</div>
<div id="main" class="maincontent">
@include('Parents.topnav')
<div id="students">

@for($i=0; $i < count(explode(",",$students)) ; $i++)
  <div id="student">
  <div id="innerstu">
    <h6 style="font-weight: bold; font-size: 13px;"  class="text-center text-danger">{{ $fnames[$i] }} {{ $lnames[$i] }}</h6>
    <img style="height: 70%; width: 100%;" src="images/{{ $profiles[$i] }}" class="img-thumbnail" alt="Profile">

    <h6 class="text-center mt-1"><a class="mt-3" id="linktostudentdetails" href='/studentdetails/{{ $ids[$i] }}'>View Details</a></h6>
    </div>

  </div>
@endfor
 
</div>

    
</div>
</div>
</div>
@endsection 



@section('script')
<script type="text/javascript">

</script>
@endsection