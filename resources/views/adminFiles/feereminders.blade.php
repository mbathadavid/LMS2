@extends('layouts.layout')

@section('title','Send Fee Reminders')

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

<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 col-sm-12">
    <form method="POST" action="#" id="feereminderform" enctype="multipart/form-data">
    <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
        <div class="table-responsive">
        <table class="table">
            <thead class="w3-green">
            <tr>
                <th scope="col">Remove</th>
                <th scope="col" class="d-none">Adm/UPI</th>
                <th scope="col">Name</th>
                <th scope="col">Fee Balance</th>
                <th scope="col">Parent's Contact</th>
                <th scope="col">Message (Editable)</th>
            </tr>
            </thead>
            <tbody>
                   @foreach($students as $student)
                    @if($student['parentinfo'] !== NULL)
                        <tr>
                            @if($student['AdmissionNo'] === NULL)
                            <td><input checked type="checkbox" value="{{ $student['id'] }}" name="removemessaging[]" id="removemessaging"></td>
                            <td class="d-none"><input type="text" style="width: auto;" readonly name="stunum[]" id="stunum" value="{{ $student['UPI'] }}" class="form-control"></td>
                            @else
                            <td><input checked type="checkbox" value="{{ $student['id'] }}" name="removemessaging[]" id="removemessaging"></td>
                            <td class="d-none"><input type="text" style="width: auto;" readonly name="stunum[]" id="stunum" value="{{ $student['AdmissionNo'] }}" class="form-control"></td>
                            @endif
                            <td><input stuid="{{ $student['id'] }}" type="text" style="width: auto;" readonly name="stuname[]" id="stuname" value="{{ $student['Fname'] }} {{ $student['Lname'] }}" class="form-control"></td>
                            <td><input stuid="{{ $student['id'] }}" type="text" style="width: auto;" readonly name="feebal[]" id="feebal" value="{{ $student['ovbalance'] }}" class="form-control"></td>
                            <td><input stuid="{{ $student['id'] }}" type="tel" style="width: auto;" readonly name="parentnumber[]" id="parentnumber" value="{{ explode(',',$student['parentinfo'])[3] }}" class="form-control"></td>
                            <td>
                                <textarea stuid="{{ $student['id'] }}" style="width: auto;" name="message[]" id="message" cols="30" rows="6" class="form-control">Hello {{ explode(',',$student['parentinfo'])[0] }} {{ explode(',',$student['parentinfo'])[1] }}, {{ session()->get('schooldetails.name') }} wishes to remind you that your child ({{ $student['Fname'] }} {{ $student['Lname'] }}) has an outstanding fee balance of {{ $student['ovbalance'] }}. Please purpose to pay on time.</textarea>
                            </td>
                        </tr>
                    @endif
                   @endforeach
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

        <input type="submit" value="SEND FEE REMINDERS" id="submitfeereminderbtn" class="form-control btn btn-sm btn-rounded-0 w3-red d-none">
    </form>
    </div>
</div>

<hr>
<div class="row justify-content-center">
    <div class="col-lg-10 col-md-10 col-sm-12">
        <div class="table-responsive">
            <h6 class="text-center text-danger">Parent's for the following Students Have not been Registered</h6>
        <table class="table">
            <thead class="w3-green">
            <tr>
                <th scope="col">Adm/UPI</th>
                <th scope="col">Name</th>
                <th scope="col">Class</th>
                <th scope="col">Fee Balance</th>
            </tr>
            </thead>
            <tbody>
                   @foreach($students as $student)
                    @if($student['parentinfo'] === NULL)
                        <tr>
                            @if($student['AdmissionNo'] === NULL)
                            <td>{{ $student['UPI'] }}</td>
                            @else
                            <td>{{ $student['AdmissionNo'] }}</td>
                            @endif
                            <td>{{ $student['Fname'] }} {{ $student['Lname'] }}</td>
                            <td>{{ $student['current_class'] }}</td>
                            <td>{{ $student['ovbalance'] }}</td>
                        </tr>
                    @endif
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
 
//Work On Removing Students
$(document).on('change','#removemessaging',function(e){
    var selectedbox = $(this).val();

    $('#feereminderform').find(`input[stuid='${selectedbox}']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })

    $('#feereminderform').find(`textarea[stuid='${selectedbox}']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })
})

//Submit General Reporting 
    $("#feereminderform").submit(function(e){
            e.preventDefault();
            $('#submitfeereminderbtn').val('PLEASE WAIT...');
            var sid = "{{ session()->get('schooldetails.id') }}";

            var formData = new FormData($('#feereminderform')[0]);
            formData.append('sid',sid);

            $.ajax({
                method: 'POST',
                url: '/sendfeereminder',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                    $('#submitfeereminderbtn').val('SEND FEE REMINDERS');
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

})
</script>
@endsection