@extends('layouts.layout')

@section('title','Results/Marks')

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
<h4 class="text-danger">Marks Computation</h4>
@if(count($students) == 0)
<h6 class="text-center text-success">There are currently no students in <b>{{ $currentclass['class'] }} {{ $currentclass['stream'] }}</b>.Go to <a href="/students"> and promote students to this class.</a></h6>
@else
<div class="row border border-success border-2">
    <div class="col-lg-12 d-flex justify-content-space-between align-items-center">
        <h5 class="text-primary bg-info p-1 m-1">{{ $currentexam['Examination'] }}</h5>
        <h5 class="text-danger p-1 m-1">{{ $currentexam['ExamType'] }}</h5>
        <h5 class="text-success bg-info p-1 m-1"> {{ $currentclass['class'] }} {{ $currentclass['stream'] }}</h5>
        <form action="#" method="post" id="subselectform">
            <div class="form-group">
             <select name="subject" id="subjectdiv" class="form-control">
                <option value="">--Select Subject To View/Add Marks--</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->subject }},{{ $subject->id }}">{{ $subject->subject }}</option>
                    @endforeach
             </select>
             <div class="invalid-feedback"></div>
            </div>
        </form>
        <h5 id="subject1" class="text-danger border border-1 border-success p-1 m-1">SUBJECT</h5>
    </div>
</div>

<div class="p-1">
    <button id="marksaddbtn" class="btn btn-sm btn-danger rounded-0"><i class="fas fa-plus-circle"></i>&nbsp;ADD MARKS</button>
    <button id="marksviewbtn" class="btn btn-sm btn-success rounded-0"><i class="fas fa-eye"></i>&nbsp;VIEW MARKS</button>
</div>

<div id="response"></div>
<div id="entermarks" class="row d-none w3-animate-left">
<h6 id="entermarksalert" class="text-center text-success d-none">We found no marks for <b><span id="addingsubject"></span></b></h6>
<form id="marksform" class="border border-2 border-danger m-2" action="#" method="post">
<input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
<input type="text" value="{{ $currentclass['id'] }}" name="classfield" id="classfield" hidden>
<input type="text" value="{{ $currentexam['id']  }}" name="examfield" id="examfield" hidden>
<input type="text" value="{{ $currentexam['Examination']  }}" name="examnane" id="examnane" hidden>
<input type="text" value="{{ $currentclass['class']  }} {{ $currentclass['stream']  }}" name="classname" id="classname" hidden>
<input type="number" name="subjectno" id="subjectno" hidden>
<input type="text" name="subjectname" id="subjectname" hidden>
<div class="form-group">
<label for=""><h6>Maximum Score for <span class="text-success" id="subject"></span> <span class="text-danger">{{ $currentexam['Examination']  }}</span></h6></label>
<input type="number" name="maxscoreset" id="maxscoreset" class="form-control">
<div class="invalid-feedback"></div>
</div>
<div class="table-responsive">
<table class="table">
<thead>
    <tr>
        <th scope="col">Eliminate</th>
        <th scope="col">Admission No</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Marks Scored</th>
        <!---
        <th scope="col">Maximum Possible Score</th>
        --->
            </tr>
        </thead>
        <tbody id="entermarkstbody">
           @foreach($students as $student)
            <tr id="tablerow" sval="{{ $student->id }}">
                <td><input value="{{ $student->id }}" type="checkbox" name="disable" id="disable"></td>
                <td><input send="send" sval="{{ $student->id }}"  readonly type="number" value="{{ $student->AdmissionNo }}" name="admissionnumber[]" id="admissionnumber" class="form-control admissionnumber"></td>
                <td><input send="send" sval="{{ $student->id }}" readonly type="text" value="{{ $student->Fname }}" name="firstname[]" id="firstname" class="form-control firstname"></td>
                <td><input send="send" sval="{{ $student->id }}" readonly type="text" value="{{ $student->Lname }}" name="lname[]" id="lname" class="form-control lname"></td>
                <td>
                    <div class="form-group">
                        <input send="send" sval="{{ $student->id }}" type="number" class="form-control maxscored" name="maxscored[]" id="maxscored">
                        <div class="invalid-feedback"></div>
                    </div>
                </td>
            </tr>

            </div>
           @endforeach
        </tbody>
</table>
</div>
<div class="form-group mb-1 d-grid">
<button id="submitmarksbtn" class="btn btn-sm btn-success" type="submit">UPLOAD MARKS FOR <span id="subject3"></span></button>
</div>
</form>
</div>

<div id="marksviewdiv" class="row w3-animate-right">
    <h6 id="alertmarks" class="text-center w3-red p-2 d-none">Some previously added marks for <b><span id="addedsubject"></span></b> were found.You can either delete and add afresh or edit.</h6>
    <form id="markupdateform" style="background-color: #f2f2f2" class="p-3" action="#">
        <!-- <h6 class="text-center text-success">Click <b>Edit</b> button to edit marks</h6> -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Adm No</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col"><span class="text-danger" id="subjectview"></span><br> Score</th>
                        <th scope="col">Out Of</th>
                    </tr>
                </thead>
                <tbody id="viewmarkstable">
                <h5 id="marksviewheading" class="w3-green p-2 text-center">Select a Subject to View or Add Marks</h5>
                <!-- @foreach($students as $student)
                <tr id="viewtablerow" sval="{{ $student->id }}">
                    <td><input value="{{ $student->id }}" type="checkbox" name="enable" id="enable"></td>
                    <td><input send="send" sval="{{ $student->id }}"  readonly type="number" value="{{ $student->AdmissionNo }}" name="viewadmissionnumber[]" id="viewadmissionnumber" class="form-control"></td>
                    <td><input send="send" sval="{{ $student->id }}" readonly type="text" value="{{ $student->Fname }}" name="viewfirstname[]" id="viewfirstname" class="form-control"></td>
                    <td><input send="send" sval="{{ $student->id }}" readonly type="text" value="{{ $student->Lname }}" name="viewlname[]" id="viewlname" class="form-control"></td>
                    <td><input send="send" sval="{{ $student->id }}" readonly type="text" value="" name="viewmarks[]" id="viewlname" class="form-control"></td>
                    <td><input send="send" sval="{{ $student->id }}" readonly type="text" value="" name="viewmaxscore[]" id="viewlname" class="form-control"></td>
                </tr>
            </div>
           @endforeach   -->
                </tbody>
            </table>
        </div>
        <div class="form-group mb-2 d-grid">
        <input id="updatemarks" type="submit" value="UPDATE MARKS" class="form-control btn btn-sm btn-danger d-none">
        </div>
    </form>

    
    <form id="withoutmarksadd"  class="d-none mt-2 p-3" action="#">
        <h6 class="text-center w3-green p-2">Marks for the following students were not found. Click <b>Add</b> to add their marks</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Adm No</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col"><span class="text-danger" id="subjectview"></span><br> Score</th>
                        <th scope="col">Out Of</th>
                    </tr>
                </thead>
                <tbody id="viewmarkstable2">
                
                </tbody>
            </table>
        </div>
        <div class="form-group d-grid">
        <input id="marksadd" type="submit" value="ADD MARKS" class="form-control btn btn-sm w3-green d-none">
        </div>
    </form>
</div>
@endif

</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        var markstoupdate = [];
        var maxscore = 0;
        var subjecttocheck

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#subjectdiv').change(function(e){
            e.preventDefault()
            var subject = $('#subjectdiv').val()
            var subinfo = subject.split(',');
            $('#subject').text(subinfo[0]);
            $('#subject1').text(subinfo[0]);
            $('#subjectname').val(subinfo[0]);
            $('#subjectno').val(subinfo[1]);
            $('#subjectview').text(subinfo[0].toUpperCase())
            $('#subject3').text(subinfo[0].toUpperCase());
            $('#maxdiv').removeClass('d-none');
            $('#subjectview').text(subinfo[0].toUpperCase());
        })
        $('#maxscoreset').change(function(e){
            e.preventDefault();
            $('#maxscore').val($(this).val())
            maxscore = JSON.parse($(this).val());
        })
       //Submit marks ajax request
      $('#marksform').submit(function(e){
          e.preventDefault();
          var formData = new FormData($(this)[0])

          $('#marksform').find("input[id='maxscored']").each(function(i){
             $(this).removeClass('is-invalid');
         })
         $('#marksform').find("input[id='maxscored']").each(function(i){
             $(this).removeClass('is-valid');
         })
          $.ajax({
              method: 'POST',
              url: '/addmarks',
              contentType: false,
              processData: false,
              data: formData,
              success: function(res){
                $('#subject1').text('');
                  //console.log(res)
                if (res.status == 400) {
                    showError('maxscoreset', res.messages.maxscoreset);
                    showError('subjectdiv', res.messages.subjectno);
                } else if(res.status == 401){
                    //$('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><p>'+res.messages+'</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#marksform').find("input[id='maxscored']").each(function(i){
                        if ($(this).is(':disabled')) {

                        } else{
                          $(this).val() == '' ? $(this).addClass('is-invalid') : $(this).addClass('is-valid')
                        }      
                    })  
                } else if(res.status == 402){
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#marksform').find("input[id='maxscored']").each(function(i){
                        if ($(this).is(':disabled')) {

                        } else{
                          $(this).val() > maxscore ? $(this).addClass('is-invalid') : $(this).addClass('is-valid')
                        }      
                    })   
                } else if(res.status == 200){
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#marksform')[0].reset();
                    $('#subselectform')[0].reset();
                }
              }
          })
      })
      //View subject for one subject
      $(document).on('click', '#viewmarks',function(e){
          e.preventDefault();
          
      }) 
     //Eliminate a students from marks handling
        $(document).on('change', '#disable',function(e){
         e.preventDefault();
        var selectedbox = $(this).val()

         $('#marksform').find(`tr[sval='${selectedbox}']`).each(function(i){
            $(this).toggleClass('eliminated')
        }) 

        $('#marksform').find(`input[sval='${selectedbox}']`).each(function(i){
            $(this).prop("disabled", !$(this).prop("disabled"));
        })
     }) 
     //View marks
     $(document).on('click','#marksaddbtn',function(){
        $('#subjectdiv').removeClass('is-invalid');
        $('#withoutmarksadd').addClass('d-none');
         if ($('#subjectdiv').val() == '') {
            showError('subjectdiv', 'You must select a subject to add marks');
             alert('You must select a subject to Add Marks')
         } else {
            $('#entermarksalert').addClass('d-none');
            $('#entermarks').addClass('d-none');
            $('#marksviewdiv').addClass('d-none');
            var exam = {{ $currentexam['id'] }};
            var classid = {{ $currentclass['id']  }};
            var sub = $('#subjectdiv').val().split(',')[0];
            $.ajax({
                method: 'GET',
                url: `/fetchmarks/${exam}/${classid}/${sub}`,
                contentType: false,
                processData: false,
                success: function(res){
                    //$('#subject1').text('');
                    //console.log(res.students);

                    var students = res.students.filter(element => {
                        if (element.suborlearningpaths != null) {
                            return element.suborlearningpaths?.includes(res.subject);
                        }   
                    });

                    if (students.length == 0) {
                        $('#entermarks').removeClass('d-none');
                        $("#entermarkstbody").html('');
                        $("#submitmarksbtn").addClass('d-none');
                        $("#entermarkstbody").append('<h6 class="text-center">No students Enrolled to take '+sub+' in ' +res.class+' .Please Enroll students for this subject.</h6>');
                    } else {
                    if (res.marks.length > 0) {
                    $('#marksviewdiv').removeClass('d-none');
                    $("#submitmarksbtn").removeClass('d-none');
                    $("#viewmarkstable").html('')
                    $("#viewmarkstable2").html('')

                    $.each(students,function(key,item){
                    var appenddata = '';
                    var appenddata2 = '';
                    appenddata +='<tr deladm="'+item.AdmissionNo+'">';
                    appenddata2 +='<tr>';
                    if (res.student.split(',').includes(item.AdmissionNo)) {
                        $("#marksviewheading").addClass('d-none');
                        appenddata +='<td><input value="'+item.id+'" type="checkbox" name="enableupdate[]" id="enableupdate"> <span class="text-danger"><b>Edit</b></span></td>';
                        appenddata +='<td><button value="'+item.AdmissionNo+'" class="btn btn-sm w3-red" id="delbtn"><i class="fas fa-trash"></i></button></td>';
                        appenddata +='<td><input send="send" readonly disabled type="number" value="'+item.AdmissionNo+'" sval2="'+item.id+'" name="viewadmissionnumber[]" id="viewadmissionnumber" id2="updation" class="form-control"></td>';
                        appenddata +='<td class="d-none"><input send="send" readonly disabled type="number" value="'+res.pids[item.AdmissionNo]+'" sval2="'+item.id+'" name="pkeys[]" id="pkeys" id2="updation" class="form-control"></td>';
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+item.Fname+'" sval2="'+item.id+'" name="viewfirstname[]" id="viewfirstname" id2="updation" class="form-control"></td>';
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+item.Lname+'" sval2="'+item.id+'" name="viewlname[]" id="viewlname" id2="updation" class="form-control"></td>'; 
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+res.admsmarks[item.AdmissionNo]+'" sval="'+item.id+'" name="viewmarks[]" id="viewlname" id2="updation" class="form-control"></td>';
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+res.outof.maxscore+'" sval="'+item.id+'" name="viewmaxscore[]" id="viewlname" id2="updation" class="form-control"></td>';  
                  } 
                    else { 
                        $('#withoutmarksadd').removeClass('d-none')
                        appenddata2 +='<td><input value="'+item.id+'" type="checkbox" name="enablemarksinsert[]" id="enablemarksinsert"> <span class="text-success"><b>Add</b></span></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="number" value="'+item.AdmissionNo+'" insid2="'+item.id+'" name="enteradmissionnumber[]" id="enteradmissionnumber" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="'+item.Fname+'" insid2="'+item.id+'" name="enterfirstname[]" id="enterfirstname" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="'+item.Lname+'" insid2="'+item.id+'" name="enterlname[]" id="enterlname" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="" insid="'+item.id+'" name="entermarks[]" id="entermarks" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="'+res.outof.maxscore+'" insid2="'+item.id+'" name="entermaxscore[]" id="entermaxscore" class="form-control"></td>';  
                    } 
                    appenddata +='</tr>';
                    $("#viewmarkstable").append(appenddata);
                    $("#viewmarkstable2").append(appenddata2);
                    })
                        $('#alertmarks').removeClass('d-none');
                        $('#addedsubject').text($('#subjectdiv').val().split(',')[0])
                    } else {
                        $('#marksviewdiv').addClass('d-none'); 
                        $("#submitmarksbtn").removeClass('d-none');
                        $('#entermarks').removeClass('d-none');
                        $("#entermarkstbody").html('');
                        $.each(students,function(key,item){
                            var appenddata3 = '';
                            appenddata3 +='<tr id="tablerow" sval="'+item.id+'">';
                            appenddata3 +='<td><input value="'+item.id+'" type="checkbox" name="disable" id="disable"></td>';
                            appenddata3 +='<td><input send="send" sval="'+item.id+'" readonly type="number" value="'+item.AdmissionNo+'" name="admissionnumber[]" id="admissionnumber" class="form-control admissionnumber"></td>';
                            appenddata3 +='<td><input send="send" sval="'+item.id+'" readonly type="text" value="'+item.Fname+'" name="firstname[]" id="firstname" class="form-control firstname"></td>';
                            appenddata3 +='<td><input send="send" sval="'+item.id+'" readonly type="text" value="'+item.Lname+'" name="lname[]" id="lname" class="form-control lname"></td>';
                            appenddata3 +='<td><div class="form-group"><input send="send" sval="'+item.id+'" type="number" class="form-control maxscored" name="maxscored[]" id="maxscored"><div class="invalid-feedback"></div></div></td>';  
                            appenddata3 +='</tr>';
                            $("#entermarkstbody").append(appenddata3); 
                        })  
                    }
                }
            }
            
                })
         }
     })
     //Add marks
     $(document).on('click','#marksviewbtn',function(){
        $('#subjectdiv').removeClass('is-invalid');
        $('#alertmarks').addClass('d-none');
        $('#withoutmarksadd').addClass('d-none');
        $('#addedsubject').text('');
        if ($('#subjectdiv').val() == '') {
            showError('subjectdiv', 'You must select a subject to view marks');
             alert('You must select a subject to View Marks')
         } else {
            $('#viewmarkstable').html(`<h6 class="text-center text-danger">Fetching marks for <b><span class="text-success">${$('#subjectdiv').val().split(',')[0]}</span></b>.Please wait...<h6>`)
            //$('#viewmarkstable2').html(`<h6 class="text-center text-danger">Fetching marks for <b><span class="text-success">${$('#subjectdiv').val().split(',')[0]}</span></b>.Please wait...<h6>`)
            $('#entermarks').addClass('d-none');
            $('#marksviewdiv').removeClass('d-none');
            //$('#viewmarkstable').addClass('d-none');
            var exam = {{ $currentexam['id'] }};
            var classid = {{ $currentclass['id']  }};
            var sub = $('#subjectdiv').val().split(',')[0];
            $.ajax({
                method: 'GET',
                url: `/fetchmarks/${exam}/${classid}/${sub}`,
                contentType: false,
                processData: false,
                success: function(res){
                    //$('#subject1').text('');

                    var students = res.students.filter(element => {
                        if (element.suborlearningpaths != null) {
                            return element.suborlearningpaths?.includes(res.subject);
                        }   
                    });


                    if (students.length == 0) {
                        $('#marksviewdiv').addClass('d-none');
                        $('#entermarks').removeClass('d-none');
                        $("#entermarkstbody").html('');
                        $("#submitmarksbtn").addClass('d-none');
                        $("#entermarkstbody").append('<h6 class="text-center">No students Enrolled to take '+sub+' in ' +res.class+' .Please Enroll students for this subject.</h6>');
                    } else {
                    if (res.marks.length == 0) {
                    $('#marksviewdiv').addClass('d-none');
                    $('#entermarksalert').removeClass('d-none');
                    $('#addingsubject').text($('#subjectdiv').val().split(',')[0]);
                    $('#entermarks').removeClass('d-none');
                    $("#entermarkstbody").html('');
                        $.each(students,function(key,item){
                            var appenddata3 = '';
                            appenddata3 +='<tr id="tablerow" sval="'+item.id+'">';
                            appenddata3 +='<td><input value="'+item.id+'" type="checkbox" name="disable" id="disable"></td>';
                            appenddata3 +='<td><input send="send" sval="'+item.id+'" readonly type="number" value="'+item.AdmissionNo+'" name="admissionnumber[]" id="admissionnumber" class="form-control admissionnumber"></td>';
                            appenddata3 +='<td><input send="send" sval="'+item.id+'" readonly type="text" value="'+item.Fname+'" name="firstname[]" id="firstname" class="form-control firstname"></td>';
                            appenddata3 +='<td><input send="send" sval="'+item.id+'" readonly type="text" value="'+item.Lname+'" name="lname[]" id="lname" class="form-control lname"></td>';
                            appenddata3 +='<td><div class="form-group"><input send="send" sval="'+item.id+'" type="number" class="form-control maxscored" name="maxscored[]" id="maxscored"><div class="invalid-feedback"></div></div></td>';  
                            appenddata3 +='</tr>';
                            $("#entermarkstbody").append(appenddata3); 
                        })   
                    } else {
                    $("#viewmarkstable").html('');
                    $('#marksviewdiv').removeClass('d-none');
                    $.each(students,function(key,item){
                    var appenddata = '';
                    var appenddata2 = '';
                    appenddata +='<tr deladm="'+item.AdmissionNo+'">';
                    appenddata2 +='<tr>';
                    if (res.student.split(',').includes(item.AdmissionNo)) {
                        $("#marksviewheading").addClass('d-none');
                        appenddata +='<td><input value="'+item.id+'" type="checkbox" name="enableupdate[]" id="enableupdate"> <span class="text-danger"><b>Edit</b></span></td>';
                        appenddata +='<td><button value="'+item.AdmissionNo+'" class="btn btn-sm w3-red" id="delbtn"><i class="fas fa-trash"></i></button></td>';
                        appenddata +='<td><input send="send" readonly disabled type="number" value="'+item.AdmissionNo+'" sval2="'+item.id+'" name="viewadmissionnumber[]" id="viewadmissionnumber" id2="updation" class="form-control"></td>';
                        appenddata +='<td class="d-none"><input send="send" readonly disabled type="number" value="'+res.pids[item.AdmissionNo]+'" sval2="'+item.id+'" name="pkeys[]" id="pkeys" id2="updation" class="form-control"></td>';
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+item.Fname+'" sval2="'+item.id+'" name="viewfirstname[]" id="viewfirstname" id2="updation" class="form-control"></td>';
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+item.Lname+'" sval2="'+item.id+'" name="viewlname[]" id="viewlname" id2="updation" class="form-control"></td>'; 
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+res.admsmarks[item.AdmissionNo]+'" sval="'+item.id+'" name="viewmarks[]" id="viewmarks" id2="updation" class="form-control"></td>';
                        appenddata +='<td><input send="send" readonly disabled type="text" value="'+res.outof.maxscore+'" sval="'+item.id+'" name="viewmaxscore[]" id="viewlname" id2="updation" class="form-control"></td>';  
                    } 
                    else { 
                        $('#withoutmarksadd').removeClass('d-none');
                        $("#viewmarkstable2").html("");
                        appenddata2 +='<td><input value="'+item.id+'" type="checkbox" name="enablemarksinsert[]" id="enablemarksinsert"> <span class="text-success"><b>Add</b></span></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="number" value="'+item.AdmissionNo+'" insid2="'+item.id+'" name="enteradmissionnumber[]" id="enteradmissionnumber" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="'+item.Fname+'" insid2="'+item.id+'" name="enterfirstname[]" id="enterfirstname" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="'+item.Lname+'" insid2="'+item.id+'" name="enterlname[]" id="enterlname" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="" insid="'+item.id+'" name="entermarks[]" id="entermarks" class="form-control"></td>';
                        appenddata2 +='<td><input send="send" readonly disabled type="text" value="'+res.outof.maxscore+'" insid2="'+item.id+'" name="entermaxscore[]" id="entermaxscore" class="form-control"></td>'; 
                    } 
                    appenddata +='</tr>';
                    $("#viewmarkstable").append(appenddata);
                    $("#viewmarkstable2").append(appenddata2);
                    })   
                    }
                }
                }
            }) 
         }
     })
     //Deal with marks updating
     $(document).on('change','#enableupdate',function(e){
        e.preventDefault();
         $('#updatemarks').removeClass('d-none')
         var selectedbox = $(this).val()

            $('#markupdateform').find(`input[sval='${selectedbox}']`).each(function(i){
            $(this).prop("disabled", !$(this).prop("disabled"));
            $(this).prop("readonly", !$(this).prop("readonly"));
            })

        $('#markupdateform').find(`input[sval2='${selectedbox}']`).each(function(i){
            $(this).prop("disabled", !$(this).prop("disabled"));
            //$(this).prop("readonly", !$(this).prop("readonly"));
        })   
        
     })

     //Delete a mark
     $(document).on('click','#delbtn',function(e){
        e.preventDefault();
         var selectedbox = $(this).val();
         var exam = {{ $currentexam['id'] }};
         var classid = {{ $currentclass['id']  }};
         var sub = $('#subjectdiv').val().split(',')[0];
        
         var confirm = window.confirm(`Are you sure you want to delete the mark for student ${selectedbox}`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deletemarks/${selectedbox}/${exam}/${classid}/${sub}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) { 
                    $('#markupdateform').find(`tr[deladm='${selectedbox}']`).each(function(i){
                        $(this).addClass('d-none');
                    })
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            } 
        
     })


     //Deal with adding
     $(document).on('change','#enablemarksinsert',function(e){
        e.preventDefault();
         $('#marksadd').removeClass('d-none')

          var selectedbox = $(this).val()


            $('#withoutmarksadd').find(`input[insid='${selectedbox}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
                 $(this).prop("readonly", !$(this).prop("readonly"));
                //console.log("This one");
            })

            $('#withoutmarksadd').find(`input[insid2='${selectedbox}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
            })   
        
     })

     //Add missing marks
     $("#withoutmarksadd").submit(function(e){
        e.preventDefault();
        $("#marksadd").val("Adding Marks. Please Wait");

        var exam = {{ $currentexam['id'] }};
        var classid = {{ $currentclass['id']  }};
        var sub = $('#subjectdiv').val().split(',')[1];
        var subname = $('#subjectdiv').val().split(',')[0];
        var sid = "{{ session()->get('schooldetails.id') }}";

        var formData = new FormData($(this)[0]);
        formData.append('examid',exam);
        formData.append('classid',classid);
        formData.append('subid',sub);
        formData.append('sid',sid);
        formData.append('subname',subname);

        $('#withoutmarksadd').find("input[id='entermarks']").each(function(i){
             $(this).removeClass('is-invalid');
         })
         $('#withoutmarksadd').find("input[id='entermarks']").each(function(i){
             $(this).removeClass('is-valid');
         })

         $.ajax({
              method: 'POST',
              url: '/addmissingmarks',
              contentType: false,
              processData: false,
              data: formData,
              success: function(res){
                $('#subject1').text('');
                $('#marksadd').val('ADD MARKS');
                if(res.status == 401){
                $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><p>'+res.messages+'</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#withoutmarksadd').find("input[id='entermarks']").each(function(i){
                        if ($(this).is(':disabled')) {

                        } else{
                          $(this).val() == '' ? $(this).addClass('is-invalid') : $(this).addClass('is-valid')
                        }      
                    })  
                } else if(res.status == 402){
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#withoutmarksadd').find("input[id='entermarks']").each(function(i){
                        if ($(this).is(':disabled')) {

                        } else{
                          $(this).val() > maxscore ? $(this).addClass('is-invalid') : $(this).addClass('is-valid')
                        }      
                    })  
                } else if(res.status == 200){
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#marksadd').addClass('d-none');
                    $('#withoutmarksadd')[0].reset();
                    $('#withoutmarksadd').addClass('d-none');
                }
              }
              })

     })


     //Update marks
     $('#markupdateform').submit(function(e){
          e.preventDefault();
          $('#updatemarks').val('Updating Marks. Please Wait...');

          var exam = {{ $currentexam['id'] }};
          var classid = {{ $currentclass['id']  }};
          var sub = $('#subjectdiv').val().split(',')[1];

          var formData = new FormData($(this)[0]);
          formData.append('examid',exam)
          formData.append('classid',classid)
          formData.append('subid',sub)

          $('#markupdateform').find("input[id='viewmarks']").each(function(i){
             $(this).removeClass('is-invalid');
         })
         $('#markupdateform').find("input[id='viewmarks']").each(function(i){
             $(this).removeClass('is-valid');
         })
          $.ajax({
              method: 'POST',
              url: '/updatemarks',
              contentType: false,
              processData: false,
              data: formData,
              success: function(res){
                $('#subject1').text('');
                $('#updatemarks').val('UPDATE MARKS');
             if(res.status == 401){
                $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><p>'+res.messages+'</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#markupdateform').find("input[id='viewmarks']").each(function(i){
                        if ($(this).is(':disabled')) {

                        } else{
                          $(this).val() == '' ? $(this).addClass('is-invalid') : $(this).addClass('is-valid')
                        }      
                    })  
                } else if(res.status == 402){
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#markupdateform').find("input[id='viewmarks']").each(function(i){
                        if ($(this).is(':disabled')) {

                        } else{
                          $(this).val() > maxscore ? $(this).addClass('is-invalid') : $(this).addClass('is-valid')
                        }      
                    })  
                } else if(res.status == 200){
                    $('#response').html('<p class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></p>');
                    $('#updatemarks').addClass('d-none');
                    $('#subselectform')[0].reset();
                } 
              }
          }) 
      }) 

    })
</script>
@endsection