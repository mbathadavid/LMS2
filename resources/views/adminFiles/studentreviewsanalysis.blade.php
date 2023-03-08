@extends('layouts.layout')

@section('title','Student Reviews Analysis')

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
<div class="row justify-content-center align-item-center">
<form action="#" method="POST" id="searchstudentform">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="form-group mb-2">
                <label for=""><h6>Enter UPI or Admission No.</h6></label>
                <input placeholder="Enter UPI or Admission No" type="text" class="form-control" name="admupi" id="admupi" required>
            </div>

            <input type="submit" value="GET STUDENT REVIEWS" id="searchstudentsubmit" class="form-control btn btn-sm btn-rounded-0 w3-green mb-2">
        </div>   
    </div> 
</form>
<hr>
</div>

<h6 id="studentheading" class="text-center p-2 d-none w3-animate-top"></h6>
<div class="row justify-content-center align-items-center">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div id="subjectreports" class="d-none w3-animate-right">
        <h6 class="text-success text-center text-danger">Subject Perfomance Reviews</h6>
        <div class="table-responsive">
        <table class="table">
                <thead class="w3-green" id="subjectreviewstable">
                <tr>
                    <th scope="col">Subject</th>
                    <th scope="col">Review</th>
                    <th scope="col">Review Date</th>
                </tr>
                </thead>
                <tbody id="subreviewstable">
                    
                </tbody>
            </table>
            </div>
            </div>
        </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div id="generalreports" class="d-none w3-animate-left">
        <h6 class="text-success text-center text-danger">General Perfomance Reviews</h6>
        <div class="table-responsive">
            <table class="table">
                <thead class="w3-green" id="generalreviewstable">
                <tr>
                    <th scope="col">Review</th>
                    <th scope="col">Review Date</th>
                </tr>
                </thead>
                <tbody id="genreviewstable">
                    
                </tbody>
            </table>
            </div>
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

    //Submit Student Search
    $("#searchstudentform").submit(function(e){
            e.preventDefault();
            $('#searchstudentsubmit').val('PLEASE WAIT...');
            var sid = "{{ session()->get('schooldetails.id') }}";

            var formData = new FormData($('#searchstudentform')[0]);
            formData.append('sid',sid);

            $.ajax({
                method: 'POST',
                url: '/fetchstudentreviews',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                    $('#searchstudentsubmit').val('GET STUDENT REVIEWS'); 
                    if (res.status == 401) {
                        swal({
                            icon: "warning",
                            text: `${res.messages}`,
                            button: "Close",
                        }); 
                    } else if (res.status == 200) {
                        $("#studentheading").removeClass('d-none');
                        $("#studentheading").text(res.student[0].Fname+' '+res.student[0].Lname+' Reviews');

                        //Work on subjectreviews start
                        $("#subjectreports").removeClass('d-none');
                        if (res.subjectreports.length == 0) {
                            $('#subreviewstable').html('<h5>No Subject Reviews found</h5>');
                        } else {
                            $('#subreviewstable').html('');
                            $.each(res.subjectreports, function(key,item){
                                $('#subreviewstable').append('<tr>\
                                    <td>'+item.subject+'</td>\
                                    <td>'+item.report+'</td>\
                                    <td>'+item.date+'</td>\
                                </tr>');
                            });  

                        // $("#subjectreviewstable").DataTable().fnDestroy()

                        // $('#subjectreviewstable').DataTable({
                        //     ordering: false,
                        //     paging: false,
                        //     searching: true
                        //  });
                    }
                //Work on subjectreviews end

                //Work on general start
                    $("#generalreports").removeClass('d-none');
                        if (res.generalreports.length == 0) {
                            $('#genreviewstable').html('<h5>No General Reviews for the student found.</h5>');
                        } else {
                            $('#genreviewstable').html('');
                         $.each(res.generalreports, function(key,item){
                            var html = '';
                            html += '<tr>';
                            html += '<td>'+item.report+'</td>';
                            html += '<td>'+item.date+'</td>';
                            html += '</tr>';
                            html += '<hr>';

                            $("#genreviewstable").append(html);
                        });  
                    }
                //Work on general start

                    }
               }
            })
        });

})
</script>
@endsection