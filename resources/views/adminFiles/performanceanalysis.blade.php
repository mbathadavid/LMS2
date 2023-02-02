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
<div class="row justify-content-center align-item-center">
<div class="col-lg-10 col-md-10 col-sm-12">
    <button id="classanalysisbtndiv" class="btn btn-sm btn-success">Class Perfomance Analysis</button>
    <button id="subjectanalysisbtndiv" class="btn btn-sm btn-success">Subject Perfomance Analysis</button>
    <hr>
<!-- <div class="row justify-content-center align-items-center"> -->
    <div class="d-none w3-animate-left" id="classanalysisdiv">
    <h6 class="w3-red text-center p-2">Class Perfomance Analysis</h6>
    <form action="#" id="analysisform" method="post">
        <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" hidden>
        <div class="form-group mb-1">
            <label for=""><h6>Examination Thread to Analyze</h6></label>
            <select name="examthread" id="examthread" class="form-control" readonly>
            <option value="">Select Examination Thread</option>
            @foreach ($threads as $thread)
            <option value="{{ $thread['id'] }}">{{ $thread['name'] }}, {{ $thread['term'] }}, {{ $thread['year'] }}</option>
            @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group mb-1">
            <label for=""><h6>Select class</h6></label>
            <select name="class" id="class" class="form-control" readonly>
                <option value="">Select Class</option>
                <option value="FORM ONE">FORM ONE</option>
                <option value="FORM TWO">FORM TWO</option>
                <option value="FORM THREE">FORM THREE</option>
                <option value="FORM FOUR">FORM FOUR</option>
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <input type="submit" id="analysebtn" value="ANALYZE" class="btn w3-green btn-rounded-0 btn-sm form-control">
        </form>
    </div>

    <div class="d-none w3-animate-right" id="subjectanalysisdiv">
    <h6 class="w3-indigo text-center p-2">Subject Perfomance Analysis</h6>
    <form action="#" id="subjectanalysisform" method="post">
        <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" hidden>
        <div class="form-group mb-1">
            <label for=""><h6>Examination Thread to Analyze</h6></label>
            <select name="subexamthread" id="subexamthread" class="form-control" readonly>
            <option value="">Select Examination Thread</option>
            @foreach ($threads as $thread)
            <option value="{{ $thread['id'] }}">{{ $thread['name'] }}, {{ $thread['term'] }}, {{ $thread['year'] }}</option>
            @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group mb-1">
            <label for=""><h6>Select class</h6></label>
            <select name="subclass" id="subclass" class="form-control" readonly>
                <option value="">Select Class</option>
                <option value="FORM ONE">FORM ONE</option>
                <option value="FORM TWO">FORM TWO</option>
                <option value="FORM THREE">FORM THREE</option>
                <option value="FORM FOUR">FORM FOUR</option>
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group mb-1">
            <label for=""><h6>Select Subject</h6></label>
            <select name="subject" id="subject" class="form-control" readonly>
                <option value="">Select Subject</option>
                @foreach ($subjects as $subject)
                <option value="{{ $subject['id'] }}">{{ $subject['subject'] }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>

        <input type="submit" id="subjectanalysebtn" value="ANALYZE" class="btn w3-green btn-rounded-0 btn-sm form-control">
        </form>
    </div>
<!-- </div> -->
<hr>
<hr>

<div class="mt-2">
<h4 id="noresultsdiv" class="d-none w3-animate-left w3-red text-center"></h4>
<div class="d-none" id="classvisualizationdiv">
<div id="analysisdiv" class="w3-animate-right">
<div id="classesmeanvisualization" style="width: 100%; height: auto">

</div>
<div class="table-responsive">
    <h6 class="text-center w3-red p-2 mb-0">Class Means Visualization</h6>
    <table class="table">
        <thead>
            <tr class="w3-green">
                <th scope="col">Class</th>
                <th scope="col">Mean</th>
                <th scope="col">Number of Students</th>
                <th scope="col">A</th>
                <th scope="col">A-</th> 
                <th scope="col">B+</th> 
                <th scope="col">B</th> 
                <th scope="col">B-</th> 
                <th scope="col">C+</th> 
                <th scope="col">C</th> 
                <th scope="col">C-</th> 
                <th scope="col">D+</th> 
                <th scope="col">D</th> 
                <th scope="col">D-</th> 
                <th scope="col">E</th> 
                <th scope="col">View</th> 
            </tr>
        </thead>
        <tbody id="classmeanstable">
            
        </tbody>
    </table>
    </div>
    <hr>

    <div class="table-responsive">
    <h6 class="text-center w3-red p-2 mb-0">Subject Means Visualization</h6>
    <table class="table">
        <thead>
            <tr class="w3-green">
                <th scope="col">Class</th>
                <th scope="col">Subject</th>
                <th scope="col">Mean</th>
                <th scope="col">Number of Students</th>
            </tr>
        </thead>
        <tbody id="subjectmeanstable">
            
        </tbody>
    </table>
    </div>
    </div>
</div>

<div class="d-none" id="subjectvisualizationdiv">
<div id="subjectmeanvisualizationdiv" style="width: 100%; height: auto">

</div>
<div class="table-responsive">
    <h6 class="text-center w3-indigo p-2 mb-0">Subject Mean Visualization</h6>
    <table class="table">
        <thead>
            <tr class="w3-green">
                <th scope="col">Class</th>
                <th scope="col">Subject</th>
                <th scope="col">Mean</th>
                <th scope="col">Number of Students</th>
                <th scope="col">View</th>
            </tr>
        </thead>
        <tbody id="subjectmeanstable2">
            
        </tbody>
    </table>
    </div>
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
google.charts.load('current', {'packages':['corechart']});
$(document).ready(function(){
// google.charts.setOnLoadCallback(drawmeanChart);

    $("#classanalysisbtndiv").click(function(e){
        e.preventDefault();
        $("#classanalysisdiv").removeClass('d-none');
        $("#subjectanalysisdiv").addClass('d-none');
    })

    $("#subjectanalysisbtndiv").click(function(e){
        e.preventDefault();
        $("#classanalysisdiv").addClass('d-none');
        $("#subjectanalysisdiv").removeClass('d-none');
    })

    //set csrf
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

    //Function to Draw a chart Class mean Visualization
    function drawmeanChart(dataarray) {
        //var data = google.visualization.arrayToDataTable(data);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Class');
        data.addColumn('number', 'Mean');
        data.addColumn('number', 'A');
        data.addColumn('number', 'A-');
        data.addColumn('number', 'B+');
        data.addColumn('number', 'B');
        data.addColumn('number', 'B-');
        data.addColumn('number', 'C+');
        data.addColumn('number', 'C');
        data.addColumn('number', 'C-');
        data.addColumn('number', 'D+');
        data.addColumn('number', 'D');
        data.addColumn('number', 'D-');
        data.addColumn('number', 'E');

        data.addRows(dataarray);

        var options = {
          title: 'Class Mean and Grade Breakdown Perfomance Analysis',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('classesmeanvisualization'));

        chart.draw(data, options);
      }

    //Function to draw Subject visualization chart
    function drawsubjectmeanChart(dataarray) {
        //var data = google.visualization.arrayToDataTable(data);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Class');
        data.addColumn('number', 'Mean Mark');
        data.addColumn('number', 'Number of Students');

        data.addRows(dataarray);

        var options = {
          title: 'Class Subject Perfomance Analysis',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('subjectmeanvisualizationdiv'));

        chart.draw(data, options);
      }

    //Submit analysis form
    $("#analysisform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($('#analysisform'))
            $('#analysebtn').val('PLEASE WAIT...');
            var formData = new FormData($('#analysisform')[0]);

            $.ajax({
                method: 'POST',
                url: '/resultanalysis',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                //console.log(res);
                    $('#analysebtn').val('ANALYZE');
                   if (res.status == 400) {
                    showError('class', res.messages.class);
                    showError('examthread', res.messages.examthread);
                   } else if (res.status == 200){
                    removeValidationClasses($('#analysisform'));
                    $("#subjectvisualizationdiv").addClass('d-none');
                    $("#noresultsdiv").addClass('d-none');
                    $("#noresultsdiv").text('');
                    $("#classvisualizationdiv").removeClass('d-none');

                    $("#classmeanstable").html('');

                    //Working on visualization of Classmeans start 
                    for (let i = 0; i < res.theclassmeans.length; i++) {
                        const element = res.theclassmeans[i];
                        var html = '';
                        html += '<tr>';
                        html += '<td class="w3-grey">'+res.classformean[i]+'</td>';
                        html += '<td class="w3-grey">'+res.theclassmeans[i]+'</td>';
                        html += '<td class="w3-grey">'+res.meanclasstucounts[i]+'</td>';
                        html += '<td class="w3-grey">'+res.as[i]+'</td>';
                        html += '<td class="w3-grey">'+res.aminus[i]+'</td>';
                        html += '<td class="w3-grey">'+res.bplus[i]+'</td>';
                        html += '<td class="w3-grey">'+res.bs[i]+'</td>';
                        html += '<td class="w3-grey">'+res.bminus[i]+'</td>';
                        html += '<td class="w3-grey">'+res.cplus[i]+'</td>';
                        html += '<td class="w3-grey">'+res.cs[i]+'</td>';
                        html += '<td class="w3-grey">'+res.cminus[i]+'</td>';
                        html += '<td class="w3-grey">'+res.dplus[i]+'</td>';
                        html += '<td class="w3-grey">'+res.ds[i]+'</td>';
                        html += '<td class="w3-grey">'+res.dminus[i]+'</td>';
                        html += '<td class="w3-grey">'+res.es[i]+'</td>';
                        html += '<td class="w3-grey"><a class="btn btn-sm w3-blue" href="/analysis/'+res.classformean[i]+'/'+res.tid+'">View Students</a></td>';
                        html += '</tr>';

                        $("#classmeanstable").append(html);

                            var classes = res.classformean;
                            var classmeans = res.theclassmeans;
                            var dataarray = [];

                            classes.forEach((className, index) => {
                                dataarray.push([className, parseFloat(classmeans[index]), parseFloat(res.as[index]), parseFloat(res.aminus[index]), parseFloat(res.bplus[index]), parseFloat(res.bs[index]), parseFloat(res.bminus[index]), parseFloat(res.cplus[index]), parseFloat(res.cs[index]), parseFloat(res.cminus[index]), parseFloat(res.dplus[index]), parseFloat(res.ds[index]), parseFloat(res.dminus[index]), parseFloat(res.es[index])]);
                            });

                        google.charts.setOnLoadCallback(drawmeanChart(dataarray));
                    }
                    //Working on visualization of Classmeans End 

                    //Working on visualization of Subjectmeans start 
                    $("#subjectmeanstable").html('');
                    $.each(res.subjectmeans, function(key,item){
                        var html = '';
                        html += '<tr class="w3-grey">';
                        html += '<td>'+item.class+'</td>';

                        for (let i = 0; i < res.subids.length; i++) {
                            const element = res.subids[i];
                            if (res.subids[i] == item.subid) {
                                html += '<td>'+res.subnames[i]+'</td>';
                            }
                        }

                        html += '<td>'+item.mean_marks+'</td>';
                        html += '<td>'+item.student_count+'</td>';
                        html += '</tr>';
                        $("#subjectmeanstable").append(html);
                    })
                    //Working on visualization of Subjectmeans End 
                    
                   } else if (res.status == 401) {
                    $("#classvisualizationdiv").addClass('d-none');
                    $("#noresultsdiv").removeClass('d-none');
                    $("#noresultsdiv").text(res.messages);
                   }   
               }
            });
        })

        //Subject visualization form submit
        $("#subjectanalysisform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($('#subjectanalysisform'))
            $('#subjectanalysebtn').val('PLEASE WAIT...');
            var formData = new FormData($('#subjectanalysisform')[0]);

            $.ajax({
                method: 'POST',
                url: '/subjectanalysis',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                //console.log(res);
                    $('#subjectanalysebtn').val('ANALYZE');
                   if (res.status == 400) {
                    showError('subclass', res.messages.subclass);
                    showError('subexamthread', res.messages.subexamthread);
                    showError('subject', res.messages.subject);
                   } else if (res.status == 200){
                    removeValidationClasses($('#subjectanalysisform'));
                    $("#classvisualizationdiv").addClass('d-none');
                    //$("#noresultsdiv").addClass('d-none');
                    $("#noresultsdiv").text('');
                    $("#subjectvisualizationdiv").removeClass('d-none');

                    for (let i = 0; i < res.classes.length; i++) {
                            var dataarray = [];

                            res.classes.forEach((className, index) => {
                                dataarray.push([className, parseFloat(res.meanmarks[index]), parseFloat(res.stucounts[index])]);
                            });

                        google.charts.setOnLoadCallback(drawsubjectmeanChart(dataarray));
                    }

                    //Working on visualization of Subjectmeans start 
                    $("#subjectmeanstable2").html('');
                    $.each(res.subjectmeans, function(key,item){
                        var html = '';
                        html += '<tr class="w3-grey">';
                        html += '<td>'+item.class+'</td>';

                        for (let i = 0; i < res.subids.length; i++) {
                            const element = res.subids[i];
                            if (res.subids[i] == item.subid) {
                                html += '<td>'+res.subnames[i]+'</td>';
                            }
                        }

                        html += '<td>'+item.mean_marks+'</td>';
                        html += '<td>'+item.student_count+'</td>';

                        for (let i = 0; i < res.subids.length; i++) {
                            const element = res.subids[i];
                            if (res.subids[i] == item.subid) {
                                 html += '<td class="w3-grey"><a href="/analyzesubject/'+item.class+'/'+item.classid+'/'+res.subids[i]+'/'+res.tid+'" class="btn btn-sm w3-blue">View Students</a></td>';
                                //  html += '<td>'+res.subids[i]+'</td>';
                                 // html += '<td class="w3-grey"><a class="btn btn-sm w3-blue" href="/analyze-subject-performance/'+item.class+'/'+res.subids[i]+'/'+res.tid+'">View Students</a></td>';
                            }
                        }

                        html += '</tr>';
                        $("#subjectmeanstable2").append(html);
                    })
                    //Working on visualization of Subjectmeans End 
                    
                   } else if (res.status == 401) {
                    //$("#classvisualizationdiv").addClass('d-none');
                    $("#subjectvisualizationdiv").removeClass('d-none');
                    //$("#analysisdiv").addClass('d-none');
                    $("#noresultsdiv").removeClass('d-none');
                    $("#noresultsdiv").text(res.messages);
                   }   
               }
            });
        })
})
</script>
@endsection