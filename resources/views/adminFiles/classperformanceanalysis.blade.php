@extends('layouts.layout')

@section('title','Performance Analysis')

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
                    <hr>
                <h6 class="text-center">Grade : <span id="grade" class="text-danger"></span>, Score : <span id="score" class="text-danger"></span>, DEV : <span id="deviation" class="text-danger"></span>, OVR POS : <span id="ovrpos" class="text-danger"></span>, STR POS : <span id="strpos" class="text-danger"></span></h6>
                <table class="table">
                <thead>
                    <tr class="w3-green">
                        <th scope="col">Subject</th>
                        <th scope="col">Score (Marks)</th>
                        <th scope="col">Score (Points)</th>
                        <th scope="col">Grade</th>
                        <!-- <th scope="col">Remarks</th> -->
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
                <h6 class="mt-2">Results for <span id="assessment" class="text-danger">{{ $examthread['name'] }} ({{ $examthread['term'] }}) {{ $examthread['year'] }}</span> Produced by <b>{{ session()->get('LoggedInUser.Salutation') }} {{ session()->get('LoggedInUser.Fname') }} {{ session()->get('LoggedInUser.Lname') }}</b></h6>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!---Student Print Result Slip Modal--->


<div class="row justify-content-center align-item-center">
<div class="table-responsive">
<table class="table">
<thead>
    <tr class="w3-green">
        <th scope="col">Action</th>
        <th scope="col">Admission/UPI No</th>
        <th scope="col">Class</th>
        <th scope="col">Student Name</th>
        @for ($i = 0; $i < count($subnames); $i++)
            <th scope="col">{{$subnames[$i]}}</th>
        @endfor
        <th scope="col">Score</th>
        <th scope="col">Grade</th>
        <th scope="col">Remarks</th>
        <th scope="col">STR Position</th>
        <th scope="col">OVR Position</th>
    </tr>
        </thead>
        <tbody id="">
        @foreach ($computedmarks as $key => $computedmark)
            <tr>
                <td><button exam="{{ $examthread['name'] }} {{ $examthread['term'] }} {{ $examthread['year'] }}" adm="{{ $computedmark['AdmissionNo'] }}" cls="{{ $computedmark['Class'] }}" name="{{ $computedmark['FName'] }} {{ $computedmark['Lname'] }}" fscore="{{ $computedmark['Finalscore'] }}" fgrade="{{ $computedmark['Finalgrade'] }}" remarks="{{ $computedmark['Remarks'] }}" subjects="{{ $computedmark['Subjects'] }}" scorepoints="{{ $computedmark['ScoresByPoints'] }}" scoremarks="{{ $computedmark['ScoresByMarks'] }}" grades="{{ $computedmark['Grades'] }}" dev="{{ $computedmark['DEV'] }}" strpos="{{ $computedmark['STRPOS'] }}" ovrpos="{{ $computedmark['OVRPO'] }}" id="actionbtn" class="btn-sm btn-danger">Result Slip</button></td>
                <td>{{ $computedmark['AdmissionNo'] }}</td>
                <td>{{ $computedmark['Class'] }}</td>
                <td>{{ $computedmark['FName'] }} {{ $computedmark['Lname'] }}</td>

                @for ($i = 0; $i < count($subnames); $i++)
                    @if (in_array($subnames[$i], explode(',', $computedmark['Subjects'])))
                        <td>{{ explode(',', $computedmark['ScoresByMarks'])[array_search($subnames[$i],explode(',', $computedmark['Subjects']))] }}, {{ explode(',', $computedmark['ScoresByPoints'])[array_search($subnames[$i],explode(',', $computedmark['Subjects']))] }}, {{ explode(',', $computedmark['Grades'])[array_search($subnames[$i],explode(',', $computedmark['Subjects']))] }}</td>
                    @else 
                        <td>_</td>
                    @endif
                    
                @endfor

                <td>{{ $computedmark['Finalscore'] }}</td>
                <td>{{ $computedmark['Finalgrade'] }}</td>
                <td>{{ $computedmark['Remarks'] }}</td>
                <td>{{ $computedmark['STRPOS'] }}</td>
                <td>{{ $computedmark['OVRPO'] }}</td>
            </tr>
        @endforeach
        </tbody>
        </table>
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

    //Action btn clicking
    $(document).on('click', '#actionbtn',function(e){
         e.preventDefault();
         var adm = $(this).attr('adm');
         var subjects = $(this).attr('subjects');
         var markscores = $(this).attr('scoremarks');
         var pointscores = $(this).attr('scorepoints');
         var grades = $(this).attr('grades');
         var remarks = $(this).attr('remarks');
         var adm = $(this).attr('adm');
         var name = $(this).attr('name');
         var cls = $(this).attr('cls');
         var fscore = $(this).attr('fscore');
         var fgrade = $(this).attr('fgrade');
         var dev = $(this).attr('dev');
         var strpos = $(this).attr('strpos');
         var ovrpos = $(this).attr('ovrpos');
         var exam = $(this).attr('exam');
         filename = adm+' resultslip';

         $("#resultslipModal").modal('show');

         $("#subjectstable").html('');
         $("#stuname").text(`${name}`);
         $("#adm").text(`${adm}`);
         $("#cls").text(`${cls}`);
         $("#grade").text(fgrade);
         $("#score").text(fscore);
         $("#deviation").text(dev);
         $("#strpos").text(strpos);
         $("#ovrpos").text(ovrpos);

         for (let i = 0; i < subjects.split(',').length; i++) {
            //const element = array[i];
            var html = "";
            html += '<tr>';
            html += '<td>'+subjects.split(',')[i]+'</td>';
            html += '<td>'+markscores.split(',')[i]+'</td>';
            html += '<td>'+pointscores.split(',')[i]+'</td>';
            html += '<td>'+grades.split(',')[i]+'</td>';
            html += '</tr>';

            $("#classteacherremarks").val(remarks);

            $("#subjectstable").append(html);
         }
        
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