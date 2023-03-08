@extends('layouts.layout')

@section('title','CBC Performance Analysis')

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
<div class="row justify-content-center align-items-center">
    <div class="col-lg-10 col-md-10 col-sm-12">
    <form action="#" id="analysisform" method="post">
        <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" hidden>
        <div class="form-group mb-1">
            <label for=""><h6>Assessment to Analyze</h6></label>
            <select name="subexamthread" id="subexamthread" class="form-control">
            <option value="">Select Assessment</option>
            @foreach ($threads as $thread)
                <option value="{{ $thread['id'] }}">{{ $thread['Assessment'] }}, {{ $thread['Type'] }}</option>
            @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group mb-1">
            <label for=""><h6>Stream to analyze</h6></label>
            <select name="stream" id="stream" class="form-control">
            <option value="">Select Stream</option>
            @foreach ($streams as $stream)
                @if ($stream['stream'] == null)
                    <option value="{{ $stream['id'] }}">{{ $stream['class'] }}</option>
                @else
                    <option value="{{ $stream['id'] }}">{{ $stream['class'] }} {{ $stream['stream'] }}</option>
                @endif  
            @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <input type="submit" id="subjectanalysebtn" value="VIEW MARKS" class="btn w3-green btn-rounded-0 btn-sm form-control">
        </form>

        <hr>

        <div id="studentscores">

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

    //Submit Analysis form
    $("#analysisform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($('#analysisform'))
            $('#subjectanalysebtn').val('PLEASE WAIT...');
            var formData = new FormData($('#analysisform')[0]);

            $.ajax({
                method: 'POST',
                url: '/cbcresultanalysis',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                    $('#subjectanalysebtn').val('VIEW MARKS');
                    $("#studentscores").html('');

                    if (res.marks.length == 0 || res.students.length == 0) {
                        $("#studentscores").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>No records matching this selection found.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div');
                    } else {
                    $.each(res.students, function(key,item){
                        var admupi = item.AdmissionNo == null ? item.UPI : item.AdmissionNo;
                        var html = '';
                        html += '<div id="studentdiv">';
                        html += '<h6 id="nameheading" class="text-center p-2 mb-0">'+admupi+', '+item.Fname+' '+item.Lname+'</h5>';

                        if (res.admupis.includes(admupi)) {
                            $.each(res.admsubs, function(key,item2){
                                if (key == admupi) {
                                    html += '<div class="table-responsive">';
                                    html += '<table class="table">';
                                    html += '<thead class="w3-green">';
                                    html += '<tr>';
                                    html += '<th scope="col">Subject</th>';
                                    html += '<th scope="col">Score</th>';
                                    html += '<th scope="col">Grade</th>';
                                    html += '<th scope="col">Remarks</th>';
                                    html += '</tr>';
                                    html += '</thead>';
                                    html += '<tbody>';

                                    for (let i = 0; i < item2.length; i++) {
                                        const element = item2[i];
                                        html += '<tr>';
                                        html += '<td>'+element+'</td>';
                                        html += '<td>'+res.admmarks[key][i]+'/'+res.admmaxscores[key][i]+'</td>';
                                        html += '<td>'+res.admgrades[key][i]+'</td>';
                                        html += '<td>'+res.admremarks[key][i]+'</td>';
                                        html += '</tr>';
                                    }

                                    html += '</tbody>';
                                    html += '</table>';
                                    html += '</div>'; 
                                }
                            })
                        } else {
                            html += '<h6>No marks</h6>'
                        }

                        html += '</div>';
                        $("#studentscores").append(html);
                    });

                }
               }
            })
        })
})
</script>
@endsection