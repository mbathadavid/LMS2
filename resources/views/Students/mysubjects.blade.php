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
<div id="regresponse"></div>
@if($subjects1 == NULL)
<h4 class="text-center text-danger">You have not been enrolled to any subjects yet.</h4>
<hr>

@if($class === "GRADE TEN" || $class === "GRADE ELEVEN" || $class === "GRADE TWELVE" && $pathway1 == NULL)
<h6 class="text-center w3-red p-1">You need to enroll to a pathway</h6>
    <form method="POST" action="#" id="studentassignpathwayform" enctype="multipart/form-data">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
            <input hidden type="number" name="studentid2" id="studentid2" value="{{ session()->get('LoggedInUser.id') }}" class="form-control">

            <div class="form-group mb-2" id="pathwayassign">
                <label for="">Select the Pathway</label>
                <select class="form-control" name="path" id="path">
                <option value="">Select Pathway</option>
                <option value="Arts and Sports Science Pathway">Arts and Sports Science Pathway</option>
                <option value="Social Sciences Pathway">Social Sciences Pathway</option>
                <option value="STEM Pathway">Science, Technology, Engineering,and Mathematics Pathway</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mb-3 d-grid">
                <button type="submit" id="assignpathway" class="btn btn-sm w3-indigo">CHOOSE PATHWAY</button>
            </div> 
            </div>
        </div>
       </form>
@else
@if(count($subjects) == 0)
<h6 class="text-center text-danger">Your School Has not Registered any Subjects yet</h6>
@else
<form method="POST" action="#" id="studentassignsubsform" enctype="multipart/form-data">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
            <input hidden type="number" value="{{ session()->get('LoggedInUser.id') }}" name="studentid" id="studentid" class="form-control">
            <div id="subjectlist" class="mb-2">
                @foreach($subjects as $subject)
                    <h6><input value="{{ $subject['id'] }},{{ $subject['subject'] }}" type="checkbox" class="checkboxid" name="subjectid[]" id="subjectid">{{ $subject['subject'] }}</h6>
                @endforeach
            </div>

            <div class="form-group mb-3 d-grid">
                <button type="submit" id="assigpathway" class="btn btn-sm w3-green">ENROLL TO SUBJECTS</button>
            </div> 
            </div>
        </div>
    </form>
@endif
    
@endif

@else
@for ($i = 0; $i < count(explode(',',$subjects1)); $i++) 
    <p class="text-center">{{ explode(',',$subjects1)[$i] }} <b>(<a class="text-danger text-decoration-none text-center" href="/my-subject-perfomance/{{ session()->get('LoggedInUser.id') }}/{{ explode(',',session()->get('LoggedInUser.subids'))[$i] }}">View Perfomance and Reports</a>)</b></p>
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

         //Submit Pathway Enrollment Form
        $('#studentassignpathwayform').submit(function(e){
        e.preventDefault();
        removeValidationClasses($("#studentassignpathwayform"))
        var formData = new FormData($('#studentassignpathwayform')[0]);
        $("#assignpathway").val('PLEASE WAIT...')
            $.ajax({
                method: 'POST',
                url: '/assignpathway',
                contentType: false,
                processData: false,
                data: formData,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                    $("#assignpathway").val('CHOOSE PATHWAY')
                        if (res.status == 200) {
                            $('#regresponse').removeClass('d-none');
                            $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            window.location = '/studentlogin';
                        } else if (res.status == 400){
                            showError('path', res.messages.path);
                        } else {
                            $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                        }
                    }
                }) 
    })

     //Upload Subjects to be uploaded
     $("#studentassignsubsform").submit(function(e){
        e.preventDefault();
        removeValidationClasses($("#studentassignsubsform"))
        var formData = new FormData($('#studentassignsubsform')[0]);

        $("#assigpathway").val('REGISTERING SUBJECTS...');

        var subcount = [];
        
        $('#subjectid:checked').each(function(i){
            subcount[i] = $(this).val()
        })

        if (subcount == 0) {
            alert("You need select the subjects or learning paths to enroll the student. Click the Checkbox Besides the the Subject Name");
        } else {
            $.ajax({
                method: 'POST',
                url: '/enrollsubjects',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                if (res.status == 200) {
                    $('#regresponse').removeClass('d-none');
                    window.location = '/studentlogin';
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }     
               }
            })  
        }
     })

    })
</script>
@endsection