@extends('layouts.layout')

@section('title','Messaging')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Parents.sidebar')
</div>
<div id="main" class="maincontent">
@include('Parents.topnav')

<div class="row justify-content-center align-item-center">
    <div id="accountupdatedivres">
        
    </div>

<div class="col-lg-6 col-md-6 col-sm-12">
<h6 class="text-center text-danger">The following are the staff members and their contacts</h6>
<table class="table" id="teacherstable">
            <thead>
            <tr>
                <th scope="col">Profile</th>
                <th scope="col">Name</th>
                <th scope="col">Role</th>  
                <th scope="col">Contact</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff) 
                <tr>
                    <td><img class="img-fluid" src="images/{{ $staff['Profile'] }}" alt="Profile Picture"></td>
                    <td>{{ $staff['Salutation'] }} {{ $staff['Fname'] }} {{ $staff['Lname'] }}</td>
                    <td>{{ $staff['Role'] }}</td>
                    <td>{{ $staff['Phone'] }}</td>
                </tr>
            @endforeach
        </tbody>
        </table>
</div>

<div class="col-lg-6 col-md-6 col-sm-12">
<h6 class="text-center">Use the form below to send messages to <span class="text-danger"><b>{{ $schoolinfo->name }}</b></span></h6>
    <form action="#" class="border p-5" method="POST" enctype="multipart/form-data" id="sendmessagefrom">
        <div id="response"></div>
           <div class="row justify-content-center">
               <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="form-group mb-2">
                    <label for=""><b>Subject (Topic) of the Message</b></label>
                    <input placeholder="Enter Subject (Topic) of Message" type="text" name="subject" id="subject" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                 <div class="form-group mb-2">
                    <label for=""><b>Enter your Message in the field below</b></label>
                    <textarea style="padding: 0px; font-weight: bolder; color: #cc0066;" class="form-control" name="message" id="message" cols="30" rows="10">
                        
                    </textarea>
                    <div class="invalid-feedback"></div>
                 </div>

                <div class="form-group mb-2">
                    <label for="">Attach File <span class="text-danger"><b><sup>*</sup>(image/pdf)</span></b></label>
                    <input onchange="preview()" name="fileattachment" id="fileattachment" type="file" class="form-control" accept=".jpg, .jpeg, .png, .gif, .pdf">
                </div>

                <!-- <embed id="chosenfile" src=""> -->
                <div id="preview"></div>

                <div class="form-group mt-2">
                    <input type="submit" id="msgsendbtn" class="btn btn-success btn-sm form-control rounded-0" value="SEND MESSAGE">
                </div>

               </div> 
        </div>
       </form>
</div>

</div>
    
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
function preview(){
    $("#Preview").removeClass('d-none');
    //chosenfile.src=URL.createObjectURL(event.target.files[0]);
     // Get the file input element and the preview div
     var fileInput = document.getElementById('fileattachment');
    var previewDiv = document.getElementById('preview');

    // Get the selected file
    var file = fileInput.files[0];

    previewDiv.innerHTML = '';

    // Check the file type
    if (file.type.startsWith('image/')) {
      // If the file is an image, create an image element and set its src
      var img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      previewDiv.appendChild(img);
    } else if (file.type === 'application/pdf') {
      // If the file is a PDF, create an iframe element and set its src
      var iframe = document.createElement('iframe');
      iframe.src = URL.createObjectURL(file);
      previewDiv.appendChild(iframe);
    } else if (file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
      // If the file is a Word document, create an object element and set its data
      var object = document.createElement('object');
      object.data = URL.createObjectURL(file);
      previewDiv.appendChild(object);
    } else {
      // If the file is not an image, PDF, or Word document, display an error message
      alert('Error: Unsupported file type');
    }
}
</script>

<script>
$(document).ready(function(){
    //set csrf
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    //Submit Notifications
    $("#sendmessagefrom").submit(function(e){
    e.preventDefault();
    removeValidationClasses($("#sendmessagefrom"))
    $('#msgsendbtn').val('SENDING MESSAGE. PLEASE WAIT...');

    var message = $('#message').val();
    var sid = "{{ session()->get('schooldetails.id') }}";
    var uid = "{{ session()->get('LoggedInUser.id') }}";
    var fname = "{{ session()->get('LoggedInUser.Fname') }}";
    var lname = "{{ session()->get('LoggedInUser.Lname') }}";

    var formData = new FormData($(this)[0]);

    //formData.append('numbers',numbers);
    formData.append('sid',sid);
    formData.append('uid',uid);
    formData.append('fname',fname);
    formData.append('lname',lname);

    $.ajax({
        method: 'POST',
        url: '{{ route('parent.message') }}',
        contentType: false,
        processData: false,
        data: formData,
        //dataType: 'json',
        success: function(res){
            //console.log(res);

            $('#msgsendbtn').val('SEND MESSAGE');

            if (res.status == 400) {
                showError('message', res.messages.message); 
                showError('subject', res.messages.subject);
            } else if(res.status == 200) {
                //console.log(res);

                var previewDiv = document.getElementById('preview');
                previewDiv.innerHTML = '';

                $('#sendmessagefrom')[0].reset();
                $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            }
        }
    })
})
    
})
</script>
@endsection