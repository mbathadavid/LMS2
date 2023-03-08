@extends('layouts.layout')

@section('title','DashBoard')

@section('content') 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Students.sidebar')
</div>
<div id="main" class="maincontent">
@include('Students.topnav')
<!-- <h6 class="text-center">{{ session()->get('LoggedInUser') }}</h6> -->
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-4 col-sm-10">
        <img src="{{ asset('images/' . session()->get('LoggedInUser.profile')) }}" class="img-fluid img-rounded img-thumbnail" alt="">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-10">
      <h6 class="text-center text-danger"><u><b>Personal Details</b></u></h6> 
      <p class="text-center">Full Name : <span class="text-success"><b>{{ session()->get('LoggedInUser.Fname') }} {{ session()->get('LoggedInUser.Lname') }}</b></span></p>
      <p class="text-center">Admission No : <span class="text-success"><b>{{ session()->get('LoggedInUser.AdmissionNo') }}</b></span></p>  
      <p class="text-center">UPI No : <span class="text-success"><b>{{ session()->get('LoggedInUser.UPI') }}</b></span></p>  
      <p class="text-center">Gender : <span class="text-success"><b>{{ session()->get('LoggedInUser.gender') }}</b></span></p> 
      <p class="text-center">DoB : <span class="text-success"><b>{{ session()->get('LoggedInUser.dob') }}</b></span></p> 
      <p class="text-center">Pathway : <span class="text-success"><b>{{ session()->get('LoggedInUser.pathway') }}</b></span></p> 
      <p class="text-center">Class : <span class="text-success"><b>{{ session()->get('LoggedInUser.current_class') }}</b></span></p>
      <p class="text-center">School System : <span class="text-success"><b>{{ session()->get('LoggedInUser.schoolsystem') }}</b></span></p>
      <p class="text-center">From : <span class="text-success"><b>{{ session()->get('LoggedInUser.county') }}, {{ session()->get('LoggedInUser.subcounty') }}</b></span></p>    
    </div>
    <div class="col-lg-4 col-md-4 col-sm-10">
       <h6 class="text-center text-danger"><u><b>Parent Details</b></u></h6>
       <p class="text-center">Parent's Name : <span class="text-success"><b>{{ explode(',',session()->get('LoggedInUser.parentinfo'))[0] }} {{ explode(',',session()->get('LoggedInUser.parentinfo'))[1] }}</b></span></p> 
       <p class="text-center">Parent's Phone : <span class="text-success"><b>{{ explode(',',session()->get('LoggedInUser.parentinfo'))[2] }}</b></span></p> 
       <p class="text-center">Parent's Email : <span class="text-success"><b>{{ explode(',',session()->get('LoggedInUser.parentinfo'))[3] }}</b></span></p> 
    </div>
</div>
<hr>
<div class="row justify-content-center">
<h5 class="text-center">Fee Information</h5>
<div class="col-lg-4 col-md-4 col-sm-10">
<div class="w3-green p-2">
<h6 class="text-center">Pending Fee Arrears : KSH. {{ session()->get('LoggedInUser.pendingbalances') }}</h6>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-10">
<div class="w3-green p-2">
<h6 class="text-center">Current Term Balance : KSH. {{ session()->get('LoggedInUser.feebalance') }}</h6>   
</div>   
</div>
<div class="col-lg-4 col-md-4 col-sm-10">
<div class="w3-green p-2">
<h6 class="text-center">Overall Balance : KSH. {{ session()->get('LoggedInUser.ovbalance') }}</h6>  
</div>   
</div>
<h6 class="text-center mt-2"><a class="btn btn-sm btn-danger" href="/fee-statement/{{ session()->get('LoggedInUser.id') }}">Fee Statement</a></h6>
</div> 

</div>
</div>
</div>
@endsection 



@section('script')
<script type="text/javascript">

</script>
@endsection