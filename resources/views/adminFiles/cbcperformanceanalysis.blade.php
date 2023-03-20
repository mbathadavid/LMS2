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
<!---Student Print Result Slip Modal--->
<div class="modal fade" id="resultslipModal" tabindex="-1" aria-labelledby="resultslipModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Print Student Result Slip</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="resultslipdiv">
                    <button id="downloadresultslip" class="btn w3-red btn-sm mb-1"><i class="fas fa-file-pdf"></i>&nbsp;DOWNLOAD</button>
                    <button id="printresultslip" class="btn w3-green btn-sm mb-1"><i class="fas fa-print"></i>&nbsp;PRINT</button>
                <div id="theresultslip">
                    <div class="row justify-content-center align-items-center">
                    <h6 class="text-center text-success">{{ session()->get('schooldetails.name') }}</h6>
                        <div id="resultsliplogo">
                            <img src="{{ asset('images/' . session()->get('schooldetails.logo')) }}" class=" img-fluid" alt="">
                        </div>
                        <h6 class="text-center">{{ session()->get('schooldetails.motto') }}</h6>
                        <h6 class="text-center">{{ session()->get('schooldetails.pobox') }} {{ session()->get('schooldetails.town') }}, {{ session()->get('schooldetails.phone') }}</h6>
                    </div>
                    <hr>
                <h6 class="text-center"> Name : <span id="stuname" class="text-danger"></span>, Adm/UPI : <span id="adm" class="text-danger"></span>, Class : <span id="cls" class="text-danger"></span></h6>
                <table class="table">
                <thead>
                    <tr class="w3-green">
                        <th scope="col">Learning Area</th>
                        <th scope="col">Score</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <tbody id="subjectstable">
                    
                </tbody>
                </table>
                <div class="form-group mt-2">
                    <label for=""><h6 class="text-danger"><b>Class Teacher Remarks</b></h6></label>
                    <textarea class="form-control" style="width: 100%;" name="classteacherremarks" id="classteacherremarks" cols="30" rows="3">

                    </textarea>
                </div>
                <h6 class="mt-2">Results for <span id="assessment" class="text-danger"></span> Produced by <b>{{ session()->get('LoggedInUser.Salutation') }} {{ session()->get('LoggedInUser.Fname') }} {{ session()->get('LoggedInUser.Lname') }}</b></h6>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!---Student Print Result Slip Modal--->


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

    var filename = "";

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
                    //console.log(res.assessment.Assessment);
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
                                    html += '<button assessment="'+res.assessment.Assessment+'" adm="'+admupi+'" cls="'+item.current_class+'" name="'+item.Fname+' '+item.Lname+'" admsubs="'+item2+'" admmarks="'+res.admmarks[key]+'" admmaxscores="'+res.admmaxscores[key]+'" admgrades="'+res.admgrades[key]+'" admremarks="'+res.admremarks[key]+'" id="actionbtn" class="btn-sm btn-danger m-1">Generate Result Slip</button>'
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

        //Action btn clicking
    $(document).on('click', '#actionbtn',function(e){
         e.preventDefault();
         var adm = $(this).attr('adm');
         var adm = $(this).attr('adm');
         var name = $(this).attr('name');
         var cls = $(this).attr('cls');
         var admsubs = $(this).attr('admsubs');
         var admmarks = $(this).attr('admmarks');
         var admmaxscores = $(this).attr('admmaxscores');
         var admgrades = $(this).attr('admgrades');
         var assessment = $(this).attr('assessment');
         var admremarks = $(this).attr('admremarks');
         filename = adm+' resultslip';

         $("#resultslipModal").modal('show');

         $("#subjectstable").html('');
         $("#stuname").text(`${name}`);
         $("#adm").text(`${adm}`);
         $("#cls").text(`${cls}`);

            for (let i = 0; i < admsubs.split(',').length; i++) {
                    const element = admsubs.split(',')[i];
                    html = '';
                    html += '<tr>';
                    html += '<td>'+element+'</td>';
                    html += '<td>'+admmarks.split(',')[i]+'/'+admmaxscores.split(',')[i]+'</td>';
                    html += '<td>'+admgrades.split(',')[i]+'</td>';
                    html += '<td>'+admremarks.split(',')[i]+'</td>';
                    html += '</tr>';
                    $("#subjectstable").append(html);
                }
           $("#assessment").text(assessment);          
     })

       //Print Fee Receipt
       $('#printresultslip').click(function(e){
            e.preventDefault();
            $("#theresultslip").print({
            globalStyles : true,
        })
    })

    //Download Fee Receipt
    window.onload = function(){
        document.getElementById('downloadresultslip').addEventListener('click',()=>{
            const results = this.document.getElementById('theresultslip');

            var opt = {
                //margin: 0.5,
                filename: `${filename}.pdf`,
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 1 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(results).set(opt).save();
        })
    }
})
</script>
@endsection