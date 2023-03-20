@extends('layouts.layout')

@section('title','Subject Perfomance and Reports')

@section('content')
    
    
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')
<div class="row justify-content-center align-items-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="table-responsive">
            <h6 class="text-center">Name : <span class="text-danger">{{ $student['Fname'] }} {{ $student['Lname'] }}</span></h6>
            <h6 class="text-center">Admission Number : <span class="text-danger">{{ $student['AdmissionNo'] }}</span></h6>
            <h6 class="text-center">UPI Number : <span class="text-danger">{{ $student['UPI'] }}</span></h6>
            <h5 class="text-center text-success">{{ $subject }} Periodic Reports</h5>
            <table class="table">
                    <thead>
                    <tr class="w3-green">
                        <th scope="col">Report</th>
                        <th scope="col">Date</th> 
                    </tr>
                </thead>
                <tbody>
                    @if (count($reports) == 0)
                    <tr>
                        <td><b>No reports have been given yet</b></td>
                        <td>_</td>
                    </tr>
                    @else
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report['report'] }}</td>
                                <td>{{ $report['date'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                </table>
        </div>
        <hr>

        @if($student['schoolsystem'] === "CBC")
            <div>
            <h5 class="text-center">{{ $student['Fname'] }} {{ $student['Lname'] }}'s Perfomance in <span class="text-danger">{{ $subject }}</span></h5>
            <div id="cbcscoresvisualization" class="mb-3" style="width: 100%; height: auto">

            </div>
            <div class="table-responsive">
                    <table class="table">
                    <thead>
                    <tr class="w3-green">
                        <th scope="col">Assessment</th>
                        <th scope="col">Score</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Remarks</th> 
                    </tr>
                </thead>
                <tbody>
                @for($i=0; $i < count($cbcthreads); $i++)
                        <tr>
                            <td><b>{{ $cbcthreads[$i] }}</b></td>
                            <td>{{ $cbcmarks[$i] }} / {{ $maxscores[$i] }}</td>
                            <td>{{ $cbcgrades[$i] }}</td>
                            <td>{{ $cbcremarks[$i] }}</td>
                        </tr>
                    @endfor
                </tbody>
                </table>
                </div>
            </div>
        @else
            <div>
            <h5 class="text-center">{{ $student['Fname'] }} {{ $student['Lname'] }}'s Perfomance in <span class="text-danger">{{ $subject }}</span></h5>
                <div id="844scoresvisualization" class="mb-3" style="width: 100%; height: auto">
                
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                    <thead>
                    <tr class="w3-green">
                        <th scope="col">Examination</th>
                        <th scope="col">Available Scores</th>
                        <th scope="col">Final Score</th>
                        <th scope="col">Grade</th> 
                        <th scope="col">Remarks</th> 
                    </tr>
                </thead>
                <tbody>
                    @for($i=0; $i < count($examthreads); $i++)
                        <tr>
                            <td><b>{{ $examthreads[$i] }}</b></td>
                            <td>
                                @for($k=0; $k < count(explode(',',$availablescores[$i])); $k++)
                                    <h6>{{ explode(',',$availablescores[$i])[$k] }} <span class="text-danger"><b>({{ explode(',',$thescores[$i])[$k] }})</b></span></h6>
                                    <hr>
                                @endfor
                            </td>
                            <td>{{ $regmarks[$i] }}</td>
                            <td>{{ $reggrades[$i] }}</td>
                            <td>{{ $regremarks[$i] }}</td>
                        </tr>
                    @endfor
                </tbody>
                </table>
            </div>
            <hr>

            </div>
        @endif

    </div>
</div>
  
</div>
</div>
</div>
@endsection 


@section('script')
<script>
// google.charts.load('current', {'packages':['corechart']});

$(document).ready(function(){ 
google.charts.load('current', {'packages':['corechart']});   
    //set csrf
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

//Function to Draw a chart for Position Visualization
  function drawcbcChart(dataarray) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Assessment');
        data.addColumn('number', 'Score');

        data.addRows(dataarray);

        var options = {
          title: 'Perfomance With Time',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('cbcscoresvisualization'));

        chart.draw(data, options);
      }

  //Function to Draw a chart Perfomance Visualization
  function draw844Chart(dataarray) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Examination');
        data.addColumn('number', 'Score');

        data.addRows(dataarray);

        var options = {
          title: 'Perfomance With Time',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('844scoresvisualization'));

        chart.draw(data, options);
      }

  //Function to fetch student
  function drawvisualizationCharts(){
    var stype = "{{ $student['schoolsystem'] }}";
    if (stype == "CBC") {
        var dataarray = [];
        var threads =  {!! json_encode($cbcthreads) !!};
        var marks = {!! json_encode($cbcmarks) !!};

        threads.forEach((thread, index) => {
            dataarray.push([thread, parseFloat(marks[index])]);
        });

        google.charts.setOnLoadCallback(function() {
            drawcbcChart(dataarray);
        })

        //google.charts.setOnLoadCallback(drawcbcChart(dataarray));
    } else {
        var dataarray = [];
        var threads = {!! json_encode($examthreads) !!};
        var marks = {!! json_encode($regmarks) !!};
        
        threads.forEach((thread, index) => {
            dataarray.push([thread, parseFloat(marks[index])]);
        });

        google.charts.setOnLoadCallback(function() {
            draw844Chart(dataarray);
        })

        //google.charts.setOnLoadCallback(draw844Chart(dataarray)); 
    }
}

drawvisualizationCharts();

//   function drawvisualizationCharts(){
//     var stype = "{{ $student['schoolsystem'] }}";
//         if (stype == "CBC") {
//             //google.charts.setOnLoadCallback(drawcbcChart(dataarray));
//             var dataarray =  "$cbcthreads";
//             console.log(dataarray);
//         } else {
//             var dataarray = "$examthreads";
//             //google.charts.setOnLoadCallback(draw844Chart(dataarray));
//             console.log(dataarray);
//         }
//     }
    
})
</script>
@endsection