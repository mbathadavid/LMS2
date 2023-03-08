@extends('layouts.layout')

@section('title','My Subjects')

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
<div class="row justify-content-center align-items-center">
<h5 class="text-center">My Subjects</h5>
<div class="col-lg-8 col-md-8 col-sm-12">
@if(session()->get('LoggedInUser.suborlearningpaths') == NULL)
<h3 class="text-center text-danger">You have not been enrolled to any subjects yet.</h3>
@else
@for ($i = 0; $i < count(explode(',',session()->get('LoggedInUser.suborlearningpaths'))); $i++)
    <p class="text-center">{{ explode(',',session()->get('LoggedInUser.suborlearningpaths'))[$i] }} <b>(<a class="text-danger text-decoration-none text-center" href="/my-subject-perfomance/{{ session()->get('LoggedInUser.id') }}/{{ explode(',',session()->get('LoggedInUser.subids'))[$i] }}">View Perfomance and Reports</a>)</b></p>
@endfor
@endif
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