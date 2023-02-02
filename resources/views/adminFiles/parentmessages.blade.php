@extends('layouts.layout')

@section('title','Parent Messages')

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
<!---Reply to Parent Messages Start--->
<div class="modal w3-animate-zoom modal-md" id="replymessageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="replyparentmessageform" class="p-2" method="POST" enctype="multipart/form-data">
         <div id="messagedes" class="p-2 w3-green text-center mb-2">

         </div>
         <div class="form-group mb-2">
            <input type="number" name="mid" id="mid" class="form-control" hidden>
         </div>
        <div class="form-group mb-2">
            <label for=""><h6>Type your reply in the field below</h6></label>
            <textarea name="replyfield" id="replyfield" cols="30" rows="10" class="form-control">

            </textarea>
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group mb-2">
            <label for="">Attach File <span class="text-danger"><b><sup>*</sup>(image/pdf)</span></b></label>
            <input onchange="preview()" name="fileattachment" id="fileattachment" type="file" class="form-control" accept=".jpg, .jpeg, .png, .gif, .pdf">
        </div>

        <div id="preview"></div>

        <div class="form-group">
            <input type="submit" id="submitreply" value="REPLY" class="form-control btn btn-sm w3-indigo">
        </div>

        </form>
    </div>
    </div>
    </div>
    </div>
<!---Reply to Parent Messages End--->


<h5 class="">Parent Messages</h5>
<div class="row justify-content-center align-item-center">
<div class="col-lg-8 col-md-8 col-sm-12">
<div id="response"></div>
@foreach($parentmessages as $parentmessage)
<div class="mb-3 border border-dark">
    <h6 class="w3-green p-2 text-center mb-0">{{ ucwords($parentmessage['topic']) }}</h6>
    <p class="p-2 w3-grey mt-0 mb-0">{{ $parentmessage['message'] }}</p>
    <div class="p-2">
        @if ($parentmessage['filetype'] == NULL)
            <h6 class="text-center">No files attached</h6>
        @elseif ($parentmessage['filetype'] == "pdf") 
            <embed src="images/{{ $parentmessage['filename'] }}" type="application/pdf"><br>
            <h6 class="text-center text-danger"><a class="text-warning" href='{{ asset("images/$parentmessage[filename]") }}' target="_blank">Open File in New Tab</a></h6>
        @else 
            <img class="img-fluid" src="images/{{ $parentmessage['filename'] }}" alt="File Here">
        @endif
    </div>

    <div class="p-2 w3-red mt-0">
        <h6 class="text-center">Date: {{ $parentmessage['created_at'] }}</h6>
        <h6 class="text-center">Send By: {{ $parentmessage['sendername'] }}</h6>
    </div>
    <h6 class="text-center"><button id="replybtn" value="{{ $parentmessage['id'] }}" nim="{{ $parentmessage['message'] }}" nid="{{ $parentmessage['id'] }}" class="btn btn-sm w3-indigo mt-2"><i class="fas fa-reply"></i>&nbsp;Reply</button></h6>
</div>
@endforeach
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

     //Hit Reply Btn
     $(document).on('click','#replybtn',function(e){
        e.preventDefault();

        $("#messagedes").html($(this).attr('nim'));
        $("#mid").val($(this).attr('nid'));

        $("#replymessageModal").modal('show');
     })  
     
     //Submit Reply form
     $("#replyparentmessageform").submit(function(e){
            e.preventDefault();

            var sid = "{{ session()->get('schooldetails.id') }}";
            var uid = "{{ session()->get('LoggedInUser.id') }}";
            var fname = "{{ session()->get('LoggedInUser.Fname') }}";
            var lname = "{{ session()->get('LoggedInUser.Lname') }}";
            var role = "{{ session()->get('LoggedInUser.Role') }}";
            
            var formData = new FormData($('#replyparentmessageform')[0]);

            formData.append('sid',sid);
            formData.append('uid',uid);
            formData.append('fname',fname);
            formData.append('lname',lname);
            formData.append('role',role);

            removeValidationClasses($("#replyparentmessageform"))

            $("#submitreply").val('SUBMITING REPLY. PLEASE WAIT...');

            $.ajax({
                method: 'POST',
                url: '{{ route('parent.reply') }}',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                   //console.log(res)
                   $("#submitreply").val('REPLY');
                   if (res.status == 400) {
                    showError('replyfield', res.messages.replyfield);
                   } else if(res.status == 200){
                    var previewDiv = document.getElementById('preview');
                    previewDiv.innerHTML = '';

                    $('#replyparentmessageform')[0].reset();
                    $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $("#replymessageModal").modal('hide'); 
                   }   
               }
            });
        })
    
})
</script>
@endsection