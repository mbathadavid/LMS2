@extends('layouts.layout')

@section('title','My Messages')

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
<div class="modal w3-animate-zoom modal-md" id="replyshowModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="message" class="text-center w3-green p-2 mb-2">

            </div>
            <div class="col-lg-6 col-md-8 col-sm-12 justify-content-center align-item-center">
                <h6 class="text-center"><span id="repliescount"></span> Replies</h6>
            <div id="repliesdiv">

            </div>
            </div>
        </div>
    </div>
    </div>
    </div>
<!---Reply to Parent Messages End--->

<h6 class="text-success">The Messages you have send</h6>
<div class="row justify-content-center align-item-center">
<div id="response">

</div>
<div class="col-lg-8 col-md-8 col-sm-12">
    <div class="table-responsive">
    <table class="table" id="notificationstable">
            <thead>
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Message</th>
                <th scope="col">Date Send</th>
                <th scope="col">Recipients</th>
                <th scope="col">Delete</th>  
            </tr>
        </thead>
        <tbody id="notificationstablebody">
            @foreach($mymessages as $mymessage)
                <tr class='{{ $mymessage['type'] == "noticeboard" ? "w3-grey" : "w3-green" }}'>
                    <td>{{ $mymessage['type'] == "noticeboard" ? "Notice" : "Reply to a Parent" }}</td>
                    <td>{{ $mymessage['message'] }}</td>
                    <td>{{ $mymessage['created_at'] }}</td>
                    <td>{{ $mymessage['group'] == NULL ? "Parent" : $mymessage['group'] }}</td>
                    <td><button class="btn btn-sm w3-red" id="delmsgbtn" value="{{ $mymessage['id'] }}"><i class="fas fa-trash"></i>&nbsp;Delete</button></td>
                </tr>
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
function preview(){
    chosenprof.src=URL.createObjectURL(event.target.files[0]);
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

    //Select view 
    $(document).on('click','#viewrepliesbtn',function(e){
        e.preventDefault();
        var mid = $(this).val();
        var msg = $(this).attr('msg');

        $.ajax({
                method: 'GET',
                url: `/fetchreplies/${mid}`,
                success: function(res) {
                //console.log(res)
                    $('#message').text(msg);
                    $("#repliesdiv").html('')
                    $("#repliescount").text(res.replies.length);
                    $.each(res.replies, function(key,item){
                        var html = '';
                        html += '<div class="border border-dark mb-2">'
                        html += '<p class="w3-grey p-2">'+item.message+'</p>';
                        if (item.filetype == null) {
                            html += '<h6>No File Attached</h6>'
                        } else if (item.filetype == "pdf") {
                            //html += '<embed src="{{ asset("images/'+item.filename+'") }}" type="application/pdf"><br>';
                            // html += '<embed src="'+"{{ asset('images/"+item.filename+"') }}"+'" type="application/pdf"><br>';
                            html += '<embed src="images/'+item.filename+'" type="application/pdf"><br>'
                            html += '<h6 class="text-center text-danger"><a class="text-warning" href="'+"{{ asset('images/"+item.filename+"') }}"+'" target="_blank">Open File in New Tab</a></h6>'
                        } else {
                            html += '<img class="img-fluid" src="images/'+item.filename+'" alt="File Here">'
                        }
                        html += '</div>'
                        $('#repliesdiv').append(html)
                    }); 
                }
            })

        $("#replyshowModal").modal('show');
     })
     
     //Handle deleting send message
     $(document).on('click','#delmsgbtn',function(e){
        e.preventDefault();
        var mid = $(this).val();

        var confirm = window.confirm(`Are you sure you want to delete this message?`);

        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deletemsg/${mid}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    $('#response').removeClass('d-none');
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    window.location = "{{ route('admin.mymessages') }}";
                   } else {
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }

     })
    
})
</script>
@endsection