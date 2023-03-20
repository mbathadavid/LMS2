@extends('layouts.layout')

@section('title','Send Exam Results')

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
<div id="response"></div>
<div class="row justify-content-center">
    <h6 class="text-center">SMS Balance <span class="text-danger" id="apibalancetext"></span></h6>
    <h6 class="text-center">SMS Balance on website <span class="text-danger" id="smsbalanceonsitetext"></span></h6>
</div>
<hr>
<form action="#" method="post" id="fetchstudentsform" class="p-2">
    <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
    <input type="number" value="{{ session()->get('LoggedInUser.id') }}" name="uid" id="uid" hidden>
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
            <div class="form-group">
                <label for="">Select Class</label>
                <select name="classforresults" id="classforresults" class="form-control">
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        @if($class['stream'] === NULL)
                            <option value="{{ $class['id'] }},{{ $class['educationsystem'] }}">{{ $class['class'] }}</option>
                        @else
                            <option value="{{ $class['id'] }},{{ $class['educationsystem'] }}">{{ $class['class'] }} {{ $class['stream'] }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
            <div class="form-group d-none" id="threadorexam">
                <label for="">Examination/Final Results</label>
                <select name="examorthread" id="examorthread" class="form-control">
                    <option value="">Select Examination/Final Results</option>
                    <option value="Examination">Examination</option>
                    <option value="Finalresults">Final Results</option>
                </select>
                <div class="invalid-feedback"></div>
            </div> 
        </div>

        <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
            <div class="form-group d-none" id="examorassessement">
                <label for="">Select Assessment/Examination</label>
                <select name="assessmentorexam" id="assessmentorexam" class="form-control">
                    
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <input type="submit" id="checkmarksbtn" value="CHECK STUDENTS AND MARKS" class="btn btn-sm rounded-0 form-control w3-green">
</form>
<hr>

<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 col-sm-12">
    <form method="POST" action="#" id="resultsform" enctype="multipart/form-data">
    <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
        <div class="table-responsive">
        <table class="table">
            <thead class="w3-green">
            <tr>
                <th scope="col">Remove</th>
                <th scope="col">Name</th>
                <th scope="col">Parent's Contact</th>
                <th scope="col">Message (Editable)</th>
            </tr>
            </thead>
            <tbody id="parentmessagestable">
                   
            </tbody>
            </table>
        </div>

        <div class="form-group mb-2">
            <label for=""><h6 class="text-success">Send Through</h6></label>
            <select name="sendthrough" id="sendthrough" class="form-control">
                <option value="">Select SMS Gateway</option>
                <option value="Shuleyetu">Shule yetu Gateway</option>
                <option value="Owngateway">{{ session()->get('schooldetails.name') }} Gateway</option>
            </select>
        </div>

        <input type="submit" value="SEND RESULTS" id="submitfeereminderbtn" class="form-control btn btn-sm btn-rounded-0 w3-red d-none">
    </form>
    </div>
</div>
<hr>

</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
$(document).ready(function(){
fetchschool();
var numbers = [];
var apibal = 0;
var websitebal = 0;
var smskey = "";

//set csrf
$.ajaxSetup({
 headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
 });


//Function to fetch school details
   function fetchschool(){
    var sid = "{{ session()->get('schooldetails.id') }}";
        $.ajax({
            method: 'GET',
            url: `/getschool/${sid}`,
            success: function(res) {
                var data = res.school;
                $("#smsbalanceonsitetext").text("KSH. "+data.SMSbalanceonwebsite);
                $("#apibalancetext").text("KSH."+data.SMSbalance);
                 apibal = data.SMSbalanceonwebsite;
                 websitebal = data.SMSbalance;
                 smskey = data.SMS_KEY;                
                }                   
        })
}

 //Change Classes
 $('#classforresults').change(function(e){
        e.preventDefault();
        var classid = $(this).val().split(',')[0];
        var etype = $(this).val().split(',')[1];

        var assessments = {!! $asessements !!}

        if (etype == "CBC") {
            $("#threadorexam").addClass('d-none');
            $("#examorassessement").removeClass('d-none');
            $("#assessmentorexam").html('');
            $("#assessmentorexam").html('<option value="">Select Asessment/Examination</option>');

            $.each(assessments, function(key,item){
                var html = '';
                html += '<option value="'+item.id+'">'+item.Assessment+'</option>';
                $("#assessmentorexam").append(html);
            });

        } else if (etype == "8-4-4") {
            $("#examorassessement").addClass('d-none');
            $("#threadorexam").removeClass('d-none');
        }
 })

 //Change Classes
 $('#examorthread').change(function(e){
        e.preventDefault();
        var exam = $(this).val();

        var threads = {!! $threads !!}
        var examinations = {!! $examinations !!}

        $("#examorassessement").removeClass('d-none');
        $("#assessmentorexam").html('');
        $("#assessmentorexam").html('<option value="">Select Asessment/Examination</option>');

        if (exam == "Examination") {
            $.each(examinations, function(key,item){
                var html = '';
                html += '<option value="'+item.id+'">'+item.Examination+'</option>';
                $("#assessmentorexam").append(html);
            }); 
        } else if(exam == "Finalresults") {
            $.each(threads, function(key,item){
                var html = '';
                html += '<option value="'+item.id+'">'+item.name+' '+item.term+' '+item.year+'</option>';
                $("#assessmentorexam").append(html);
            });
        }

 })

    //Work On Removing Students
    $(document).on('change','#removemessaging',function(e){
        var selectedbox = $(this).val();

        $('#resultsform').find(`input[stuid='${selectedbox}']`).each(function(i){
            $(this).prop("disabled", !$(this).prop("disabled"));
        })

        $('#resultsform').find(`textarea[stuid='${selectedbox}']`).each(function(i){
            $(this).prop("disabled", !$(this).prop("disabled"));
        })
    })

    //Submit General Reporting 
    $("#resultsform").submit(function(e){
            e.preventDefault();
            $('#submitfeereminderbtn').val('PLEASE WAIT...');
            var sid = "{{ session()->get('schooldetails.id') }}";

            var formData = new FormData($('#resultsform')[0]);
            formData.append('sid',sid);

            $.ajax({
                method: 'POST',
                url: '/sendfeereminder',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                    $('#submitfeereminderbtn').val('SEND RESULTS');
                    $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Fee Reminders Successfully Send to '+res.successfullysendmessages+' parents. Messaging costs is <span class="text-danger">KSH. '+res.costs+'</span>. Click <a href="/sms-messaging-history">this link</a> to see your send messages</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    ///$('#sendmessagefrom')[0].reset();
                    fetchschool();
                    swal({
                        className: 'green-bg',
                        icon: "success",
                        text: `Fee Reminders Successfully Send to ${res.successfullysendmessages} parents. Messaging cost is KSH. ${res.costs}`,
                        button: "Close",
                    });
               }
            })
        });


    //SMS Gateway Selection
    $("#sendthrough").change(function(e){
        e.preventDefault();
        var gateway = $(this).val();

        if (gateway == "Owngateway") {
            if (smskey == null) {
                //$("#gatewayauthorize").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! You do not have your own SMS gateway. Try selecting <b>Shule yetu Gateway</b></strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $("#submitfeereminderbtn").addClass('d-none');
                alert('Sorry! You do not have your own SMS gateway. Try selecting Shule yetu Gateway');
            } else {
                if (parseFloat(apibal) <= 5 || apibal == null) {
                    //$("#gatewayauthorize").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! You do not have enough balance in your account. Recharge so as to access this service.</b></strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $("#submitfeereminderbtn").addClass('d-none');
                    alert('Sorry! You do not have enough balance in your account. Recharge so as to access this service.');
                } else {
                    $("#submitfeereminderbtn").removeClass('d-none');
                    //$("#gatewayauthorize").html('');
                }
            }
            //$("#gatewayauthorize").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+apibal+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        } else if (gateway == "Shuleyetu") {
            if (parseFloat(websitebal) <=5 || websitebal == null) {
                //$("#gatewayauthorize").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! You do not have enough balance to send messages. Recharge your account to access the messaging service.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $("#submitfeereminderbtn").addClass('d-none');
                alert('Sorry! You do not have enough balance to send messages. Recharge your account to access the messaging service');
            } else {
                $("#submitfeereminderbtn").removeClass('d-none');
                //$("#gatewayauthorize").html('');
            }
            
        } else if (gateway == ""){
            //$("#gatewayauthorize").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Please Select the SMS Gatway</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            $("#submitfeereminderbtn").addClass('d-none');
            alert('Please Select the SMS Gatway');
        }
    })

    //Check for marks and students
    $("#fetchstudentsform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($("#fetchstudentsform"));
            $('#regresponse').addClass('d-none');
            $('#checkmarksbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#fetchstudentsform')[0]);

            $.ajax({
                method: 'POST',
                url: '/checkstudentandmarks',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                  var sname = "{{ session()->get('schooldetails.name') }}"; 
                  //console.log(res);
                  $("#checkmarksbtn").val('CHECK STUDENTS AND MARKS');
                  if (res.status == 400) {
                    showError('classforresults', res.messages.classforresults);
                    showError('assessmentorexam', res.messages.assessmentorexam);
                  } else {
                        $("#parentmessagestable").html('');
                        if (res.cls == "CBC") {
                            $.each(res.students,function(key,item){
                            if (item.parentinfo != null) {
                                var adm = item.AdmissionNo == null ? String(item.UPI) : String(item.AdmissionNo);
                                var html = '';
                                html += '<tr>';
                                html += '<td><input checked type="checkbox" value="'+item.id+'" name="removemessaging[]" id="removemessaging"></td>';
                                html += '<td><input stuid="'+item.id+'" type="text" style="width: auto;" readonly name="stuname[]" id="stuname" value="'+item.Fname+' '+item.Lname+'" class="form-control"></td>';
                                html += '<td><input stuid="'+item.id+'" type="tel" style="width: auto;" readonly name="parentnumber[]" id="parentnumber" value="'+item.parentinfo.split(',')[3]+'" class="form-control"></td>';
                                
                                var subsmarks = [];

                                $.each(res.marks,function(key,item2){
                                    
                                    if (String(item2.AdmissionNo) == adm) {
                                        subsmarks.push(item2.subject+' ('+item2.marks+'/'+item2.maxscore+')');
                                    }
                                })


                                html += '<td><textarea stuid="'+item.id+'" style="width: auto;" name="message[]" id="message" cols="35" rows="10" class="form-control">Hello '+item.parentinfo.split(',')[0]+' '+item.parentinfo.split(',')[1]+', '+sname+' wishes to inform you that your child ('+item.Fname+' '+item.Lname+') Scored the following marks in '+res.exam.Assessment+'. '+subsmarks+'</textarea></td>';
                                html += '</tr>';
                                $("#parentmessagestable").append(html); 
                            }  
                            })
                        } else if (res.cls == "8-4-4") {
                              if (res.examorthread == "Finalresults") {
                                $.each(res.students,function(key,item){
                                if (item.parentinfo != null) {
                                    var adm = item.AdmissionNo == null ? String(item.UPI) : String(item.AdmissionNo);
                                    var html = '';
                                    html += '<tr>';
                                    html += '<td><input checked type="checkbox" value="'+item.id+'" name="removemessaging[]" id="removemessaging"></td>';
                                    html += '<td><input stuid="'+item.id+'" type="text" style="width: auto;" readonly name="stuname[]" id="stuname" value="'+item.Fname+' '+item.Lname+'" class="form-control"></td>';
                                    html += '<td><input stuid="'+item.id+'" type="tel" style="width: auto;" readonly name="parentnumber[]" id="parentnumber" value="'+item.parentinfo.split(',')[3]+'" class="form-control"></td>';
                                    
                                    var subsmarks = [];
                                    var fscore = '';
                                    var fgrade = '';
                                    var strpos = '';
                                    var ovrpos = '';

                                    $.each(res.marks,function(key,item2){
                                        
                                        if (String(item2.AdmissionNo) == adm) {
                                            for (let i = 0; i < item2.Subjects.split(',').length; i++) {
                                                subsmarks.push(item2.Subjects.split(',')[i]+' ('+item2.ScoresByMarks.split(',')[i]+','+item2.Grades.split(',')[i]+')');
                                            }

                                            fscore = item2.Finalscore;
                                            fgrade = item2.Finalgrade;
                                            strpos = item2.STRPOS;
                                            ovrpos = item2.OVRPO;
                                            //subsmarks.push(item2.subject+' ('+item2.marks+'/'+item2.maxscore+')');
                                        }
                                    })

                                    html += '<td><textarea stuid="'+item.id+'" style="width: auto;" name="message[]" id="message" cols="35" rows="10" class="form-control">Hello '+item.parentinfo.split(',')[0]+' '+item.parentinfo.split(',')[1]+', '+sname+' wishes to inform you that your child ('+item.Fname+' '+item.Lname+') Scored the following marks in '+res.exam.name+'_'+res.exam.term+'_'+res.exam.year+'. '+subsmarks+'. Score ('+fscore+', '+fgrade+'). Class pos ('+strpos+') Stream pos ('+ovrpos+')</textarea></td>';
                                    html += '</tr>';
                                    $("#parentmessagestable").append(html); 
                                }  
                            })
                              } else if (res.examorthread == "Examination") {
                                    $.each(res.students,function(key,item){
                                    if (item.parentinfo != null) {
                                        var adm = item.AdmissionNo == null ? String(item.UPI) : String(item.AdmissionNo);
                                        var html = '';
                                        html += '<tr>';
                                        html += '<td><input checked type="checkbox" value="'+item.id+'" name="removemessaging[]" id="removemessaging"></td>';
                                        html += '<td><input stuid="'+item.id+'" type="text" style="width: auto;" readonly name="stuname[]" id="stuname" value="'+item.Fname+' '+item.Lname+'" class="form-control"></td>';
                                        html += '<td><input stuid="'+item.id+'" type="tel" style="width: auto;" readonly name="parentnumber[]" id="parentnumber" value="'+item.parentinfo.split(',')[3]+'" class="form-control"></td>';
                                        
                                        var subsmarks = [];

                                        $.each(res.marks,function(key,item2){
                                            
                                            if (String(item2.AdmissionNo) == adm) {
                                                subsmarks.push(item2.subject+' ('+item2.marks+'/'+item2.maxscore+')');
                                            }
                                        })


                                        html += '<td><textarea stuid="'+item.id+'" style="width: auto;" name="message[]" id="message" cols="35" rows="10" class="form-control">Hello '+item.parentinfo.split(',')[0]+' '+item.parentinfo.split(',')[1]+', '+sname+' wishes to inform you that your child ('+item.Fname+' '+item.Lname+') Scored the following marks in '+res.exam.Examination+'. '+subsmarks+'</textarea></td>';
                                        html += '</tr>';
                                        $("#parentmessagestable").append(html); 
                                    }  
                                    })
                              }  
                        }
                  }
               }
            });
        })

})
</script>
@endsection