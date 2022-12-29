@extends('layouts.layout')

@section('title','DashBoard')

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

<!-- <a href="/downloadtranscript">Download Transcript</a>
<iframe src="http://127.0.0.1:8000/getparentspdf" frameborder="0" style="background-color: grey;width: 50%;float: right;height:100%">

</iframe> -->

<!---Message modal start--->
<div class="modal w3-animate-zoom" id="writemsgModal" tabindex="-1" aria-labelledby="writemsgModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center">Send Message Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       <form action="#" method="POST" enctype="multipart/form-data" id="sendmessagefrom">
           <div class="row justify-content-center">
               <div class="col-lg-8 col-md-10 col-sm-12">
                 <div class="form-group mb-2">
                    <label for="message"><h4 class="text-danger">Type your message in the textarea below</h4></label>
                    <textarea style="padding: 0px; font-weight: bolder; color: #cc0066;" class="form-control" name="message" id="message" cols="30" rows="10">
                        
                    </textarea>
                    <div class="invalid-feedback"></div>
                 </div>

                <div class="form-group">
                    <input type="submit" id="msgsendbtn" class="btn btn-success btn-sm form-control rounded-0" value="SEND MESSAGE">
                </div>

               </div> 
        </div>
       </form>
        </div>
    </div>
    </div>
</div>
<!---Message modal End--->

<div class="row justify-content-cente align-items-center">
<div class="col-lg-4 col-md-4 col-sm-12">
<form action="#" method="POST" class="p-3" id="selectgroupform">
    <div class="form-group mb-2">
        <label for="group"><h5 class="text-success">Select The Group You Want To Communicate To</h5></label>
        <select name="group" id="group" class="form-control">
         <option value="">Select The Group</option>
         <option value="PARENTS">Parents</option>
         <option value="TEACHERS">Teachers</option>
         <option value="SUPPORT STAFF">Support Staff</option>
        </select>
    </div>

    <div class="form-group mb-3">
    <input type="submit" value="SELECT" id="selectgroupbtn" class="form-control btn btn-sm rounded-0 btn-danger">
    </div>
</form>
</div>

<div class="col-lg-8 col-md-8 col-sm-12" id="groupsection">
<h5 class="text-danger text-center d-none" id="fetchingtxt">Please Wait...</h5>
<div class="table-responsive d-none" id="thetable">
<div class="mb-2" id="sendmessagebtn">
<button id="writemsgbtn" class="btn btn-success float-end m-1"><i class="fas fa-pen"></i>&nbsp;Write Message</button>
</div>
<table class="table" id="grouptable">
    <thead class="bg-success">
    <tr>
        <th scope="col"><input value="all" type="checkbox" name="selectall" id="selectall"> Check to Select All</th>
        <th scope="col">Profile</th>
        <th scope="col">Name</th>
        <th scope="col">Phone Number</th>
        <th scope="col">Student(s)</th>
    </tr>
    </thead>
    <tbody id="groupbody">
            
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
    var numbers = []
//set csrf
$.ajaxSetup({
 headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
 });

 
//Update the select button field
 $('#group').change(function(){
    var group = $(this).val();
    $('#selectgroupbtn').val(`SELECT ${group}`)
 })

 //Handle multiple checkboxing
 $('#selectall').click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
 })

 //Show the modal for Typing a message
 $(document).on('click', '#writemsgbtn',function(e){
        e.preventDefault();

         $('#phonecheckbox:checked').each(function(i){
            numbers[i] = $(this).val()
        })

        // $('#phonecheckbox').each(function(i){
        //     if ($(this).is(':checked')) {
        //         numbers[i] = $(this).val(); 
        //     }
        // })

        if (numbers.length < 1) {
            alert('Please select the individuals who will receive the text message. You can do so by checking the checkboxes on the table'); 
        } else {
            numbers = [];

            $('#phonecheckbox:checked').each(function(i){
                numbers[i] = $(this).val()
            })

            $('#writemsgModal').modal('show');
        } 
     })

//Submit form for sending message
$("#sendmessagefrom").submit(function(e){
    e.preventDefault();
    removeValidationClasses($("#sendmessagefrom"))
    $('#msgsendbtn').val('SENDING MESSAGE. PLEASE WAIT...');

    var message = $('#message').val();
    var sid = "{{ session()->get('schooldetails.id') }}";
    var uid = "{{ session()->get('LoggedInUser.id') }}";

    var formData = new FormData($(this)[0]);

    formData.append('numbers',numbers);
    formData.append('sid',sid);
    formData.append('uid',uid);

    $.ajax({
        method: 'POST',
        url: '{{ route('admin.sendmessage') }}',
        contentType: false,
        processData: false,
        data: formData,
        //dataType: 'json',
        success: function(res){
            console.log(res);

            $('#msgsendbtn').val('SEND MESSAGE');

            if (res.status == 400) {
                showError('message', res.messages); 
            } else if(res.status == 200) {
                console.log(res);
            }
        }
    })
})

//Submit the form for fetching groups
 $('#selectgroupform').submit(function(e){
    e.preventDefault();
    $('#groupbody').html('');
    var group = $('#group').val();
    $('#selectall').prop('checked', false);

    $('#fetchingtxt').removeClass('d-none');
    //$('#groupsection').html('');

    
    var sid = "{{ session()->get('schooldetails.id') }}";
    var uid = "{{ session()->get('LoggedInUser.id') }}";

    if (group == "") {
        alert('You Must Select A group To Continue')
    } else if (group == "TEACHERS") {
        var stype = "Teacher";
        $.ajax({
                method: 'GET',
                url: `/fetchteachers/${sid}/${uid}/${stype}`,
                //dataType: 'jsons',
                success: function(res) {
                    $('#fetchingtxt').addClass('d-none');
                    $('#thetable').removeClass('d-none');

                     if (res.teachers.length == 0) {
                        $('#sendmessagebtn').addClass('d-none');
                         $('tbody').html('<h5 class="text-center text-danger">No any teachers registered as at now</h5>');
                     } else {
                        $('#sendmessagebtn').removeClass('d-none');
                         $('#groupbody').html('');
                          $.each(res.teachers, function(key,item){
                         $('#groupbody').append('<tr>\
                         <td><input value="'+item.Phone+'" type="checkbox" class="checkboxid" name="phonecheckbox" id="phonecheckbox"></td>\
                         <td><img  width="50" height="50" class="img-fluid" src="images/'+item.Profile+'" alt=""></td>\
                         <td>'+item.Salutation+' '+item.Fname+' '+item.Lname+'</td>\
                         <td>'+item.Phone+'</td>\
                         <td>N/A</td>\
                     </tr>');
                     }); 
                        //  $("#grouptable").DataTable().fnDestroy()
                        //  $('#grouptable').DataTable({
                        //  ordering: false,
                        //  paging: false,
                        //  searching: true
                        //   });
                     } 
                }

            })  
    } else if (group == "PARENTS") {
        
        $.ajax({
                method: 'GET',
                url: `/fetchparents/${sid}`,
                //dataType: 'jsons',
                success: function(res) {
                    $('#fetchingtxt').addClass('d-none');
                    $('#thetable').removeClass('d-none');

                    if (res.parents.length == 0) {
                        $('#sendmessagebtn').addClass('d-none');
                        $('#groupbody').html('<h5 class="text-center text-danger">No any parents registered as at now</h5>');
                    } else {
                        $('#sendmessagebtn').removeClass('d-none');
                        $('#groupbody').html('');
                         $.each(res.parents, function(key,item){
                            $('#groupbody').append('<tr>\
                            <td><input value="'+item.Phone+'" type="checkbox" class="phonecheckbox" name="" id="phonecheckbox"></td>\
                            <td><img  width="50" height="50" class="img-fluid" src="images/'+item.Profile+'" alt=""></td>\
                            <td>'+item.Fname+' '+item.Lname+'</td>\
                            <td>'+item.Phone+'</td>\
                            <td>'+item.Students+'</td>\
                            </tr>')
                    }); 

                    // $("#grouptable").DataTable().fnDestroy()

                    //     $('#grouptable').DataTable({
                    //     ordering: false,
                    //     paging: false,
                    //     searching: true
                    //      });

                    }  
                }
            })

    } else if (group == "SUPPORT STAFF") {
        var stype = "Support Staff";
        $.ajax({
                method: 'GET',
                url: `/fetchteachers/${sid}/${uid}/${stype}`,
                //dataType: 'jsons',
                success: function(res) {
                    $('#fetchingtxt').addClass('d-none');
                    $('#thetable').removeClass('d-none');

                    if (res.teachers.length == 0) {
                        $('#sendmessagebtn').addClass('d-none');
                        $('#groupbody').html('<h5 class="text-center text-danger">No any support staff member registered as at now</h5>');
                    } else {
                        $('#sendmessagebtn').removeClass('d-none');
                        $('#groupbody').html('');
                         $.each(res.teachers, function(key,item){
                        $('#groupbody').append('<tr>\
                        <td><input value="'+item.Phone+'" type="checkbox" class="checkboxid" name="phonecheckbox" id="phonecheckbox"></td>\
                        <td><img  width="50" height="50" class="img-fluid" src="images/'+item.Profile+'" alt=""></td>\
                        <td>'+item.Salutation+' '+item.Fname+' '+item.Lname+'</td>\
                        <td>'+item.Phone+'</td>\
                        <td>N/A</td>\
                    </tr>');
                    }); 
                    
                        // $("#grouptable").DataTable().fnDestroy()

                        // $('#grouptable').DataTable({
                        // ordering: false,
                        // paging: false,
                        // searching: true
                        //  });

                    }
                   
                }

            })
    }

 })


})
</script>
@endsection