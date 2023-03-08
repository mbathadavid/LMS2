@extends('layouts.layout')

@section('title','Fee Payment')

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

@if (session()->get('schooldetails.Mpesa_code') == NULL)
<h6 class="text-center text-danger">Unfortunately {{ session()->get('schooldetails.name') }} does collect fees through MPESA</h6>
@else
<h6 class="text-center text-success">Details of Fee payment through MPESA will be updated soon.</h6>
@endif



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