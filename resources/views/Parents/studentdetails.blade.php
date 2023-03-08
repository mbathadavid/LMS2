@extends('layouts.layout')

@section('title','Student Details')

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
<div class="col-lg-6 col-md-8 col-sm-12">
<div class="table-responsive">
<h5 class="text-center text-danger"><span class="text-success">{{ $student['Fname'] }} {{ $student['Lname'] }}'s</span> Personal Details</h5>
<img src="{{ asset('images/'.$student['profile']) }}" style="height: 200px; width: 200px;" class="img-fluid img-thumbnail mb-2" alt="Profile">
    <table class="table">
            <thead>
            <tr class="w3-green">
                <th scope="col">Personal Detail</th>
                <th scope="col">Value</th> 
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>Name</td>
                    <td>{{ $student['Fname'] }} {{ $student['Lname'] }}</td>
                </tr>
                <tr>
                    <td>Admission No</td>
                    @if ($student['AdmissionNo'] == NULL)
                    <td>No Admission Number</td>
                    @else
                    <td>{{ $student['AdmissionNo'] }}</td>
                    @endif
                </tr>
                <tr>
                    <td>UPI No</td>
                    @if ($student['UPI'] == NULL)
                    <td>No UPI Number</td>
                    @else
                    <td>{{ $student['UPI'] }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>{{ $student['gender'] }}</td>
                </tr>
                <tr>
                    <td>School System</td>
                    <td>{{ $student['schoolsystem'] }}</td>
                </tr>
                <tr>
                    <td>Learning Path</td>
                    @if ($student['pathway'] == NULL)
                    <td>N/A</td>
                    @else
                    <td>{{ $student['pathway'] }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Current Class</td>
                    <td>{{ $student['current_class'] }}</td>
                </tr>
                <tr>
                    <td>DoB</td>
                    <td>{{ $student['dob'] }}</td>
                </tr>
        </tbody>
        </table>
      </div>
      </div>
</div> 

<hr>
<hr>
<div class="row justify-content-center align-items-center">
<div class="col-lg-6 col-md-8 col-sm-12">
    <div class="table-responsive">
  <h5 class="text-center text-danger"><span class="text-success">{{ $student['Fname'] }} {{ $student['Lname'] }}'s</span> Fee Information</h5>
  <h6 class="text-center"><span class="text-success">Total Fees</span> <span class="text-danger"><b>{{ $totalfees }}</b></span>/=</h6>
  <h6 class="text-center"><a class="btn btn-sm btn-success" href="/fee-history/{{ $student['id'] }}">View Fee Payment History</a></h6>
    <table class="table">
            <thead>
            <tr class="w3-green">
                <th scope="col">Fee Balance</th>
                <th scope="col">Value</th> 
            </tr>
        </thead>
        <tbody class="w3-grey">
                <tr>
                    <td>Pending Fee Arrears</td>
                    <td>{{ $student['pendingbalances'] }}</td>
                </tr>
                <tr>
                    <td>Current Term Balance</td>
                    <td>{{ $student['feebalance'] }}</td>
                </tr>
                <tr>
                    <td><b>Total</b></td>
                    <td><b class="text-danger">{{ $student['ovbalance'] }}</b></td>
                </tr>
        </tbody>
        </table>
      </div>
    </div>
</div>

<hr>
<hr>
<div class="row justify-content-center align-items-center">
  <div class="col-lg-6 col-md-8 col-sm-12">
  <h5 class="text-center text-danger"><span class="text-success">{{ $student['Fname'] }} {{ $student['Lname'] }}'s</span> Perfomance</h5>
  @if ($student['schoolsystem'] === "8-4-4")
  <div id="positionalfluctuationdiv" class="mb-3" style="width: 100%; height: auto">

  </div>

  <div id="perfomancefluctuationdiv" class="mb-3" style="width: 100%; height: auto">

  </div>

  <div class="table-responsive">
    <table class="table">
          <thead>
            <tr class="w3-green">
                <th scope="col">Examination</th>
                <th scope="col">Score</th> 
                <th scope="col">Grade</th> 
                <th scope="col">Overall Position</th>
                <th scope="col">Stream Position</th>
                <th scope="col">Action</th>   
            </tr>
        </thead>
        <tbody class="w3-grey" id="perfomancetable">
              
        </tbody>
        </table>
    </div>
  @else
  <div class="table-responsive">
    <table class="table">
          <thead>
            <tr class="w3-green">
                <th scope="col">Assessment</th>
                <th scope="col">Type</th> 
                <th scope="col">Analyze</th>    
            </tr>
        </thead>
        <tbody class="w3-grey" id="cbcperfomancetable">
              
        </tbody>
        </table>
    </div>
  @endif
 
  </div>
</div>
<hr>
<hr>

<div class="row justify-content-center align-items-center">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h5 class="text-center text-danger"><span class="text-success">{{ $student['Fname'] }} {{ $student['Lname'] }}'s</span> Periodic Reports</h5>
    <div class="table-responsive">
    <table class="table">
          <thead>
            <tr class="w3-green">
                <th scope="col">Report</th> 
                <th scope="col">Date Given</th>    
            </tr>
        </thead>
        <tbody class="w3-grey">
            @if (count($generalreports) == 0)
              <p class="text-center text-danger">There are no reports given for this student</p>
            @else
              @foreach ($generalreports as $generalreport)
                <tr>
                  <td><b>{{ $generalreport['report'] }}</b></td>
                  <td>{{ $generalreport['date'] }}</td>
                </tr>
              @endforeach
            @endif
        </tbody>
        </table>
    </div>
  </div>
</div>

<hr>
<hr>
<div class="row justify-content-center align-items-center">
  <div class="col-lg-6 col-md-8 col-sm-12">
    <h5 class="text-center text-danger"><span class="text-success">{{ $student['Fname'] }} {{ $student['Lname'] }}'s</span> Learning Areas</h5>
    @if ($student['suborlearningpaths'] == NULL)
      <h6 class="text-center">The student is not enrolled to any subjects or learning areas.</h6>
    @else
      @for ($i = 0; $i < count(explode(',',$student['suborlearningpaths'])); $i++)
        <p class="text-center">{{ explode(',',$student['suborlearningpaths'])[$i] }} <b>(<a class="text-danger text-decoration-none text-center" href="/subject-perfomance/{{ $student['id'] }}/{{ explode(',',$student['subids'])[$i] }}">View Perfomance and Reports</a>)</b></p>
        
      @endfor
    @endif
  </div>
</div>

<hr>
<hr>
<div class="row justify-content-center align-items-center">
<h5 class="text-center text-danger"><span class="text-success">{{ $student['Fname'] }} {{ $student['Lname'] }}'s</span> Assigned Books</h5>
    @if (count($books) == 0)
      <h6 class="text-center">The student has not been issued any books.</h6>
    @else
      @for ($i = 0; $i < count($books); $i++)
        <p class="text-center">{{ $books[$i] }}</p>
      @endfor
    @endif
  </div> 
</div>

<hr>
<hr>

</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
google.charts.load('current', {'packages':['corechart']});
$(document).ready(function(){
  fetchstudentperfomance();
    //set csrf
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

//Function to Draw a chart for Position Visualization
  function drawpositionalChart(dataarray) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Examination');
        data.addColumn('number', 'Stream Position');
        data.addColumn('number', 'Overall Position');

        data.addRows(dataarray);

        var options = {
          title: 'Class and Stream Positional Fluctuation With Time',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('positionalfluctuationdiv'));

        chart.draw(data, options);
      }

  //Function to Draw a chart Perfomance Visualization
  function drawperfomanceChart(dataarray) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Examination');
        data.addColumn('number', 'Score');

        data.addRows(dataarray);

        var options = {
          title: 'Perfomance With Time',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('perfomancefluctuationdiv'));

        chart.draw(data, options);
      }

  //Function to fetch student
  function fetchstudentperfomance(){
    var stuid = "{{ $student['id'] }}";
        $.ajax({
                method: 'GET',
                url: `/fetchstudentperfomance/${stuid}`,
                //dataType: 'jsons',
                success: function(res) {
                  //console.log(res);
                  $("#perfomancetable").html('');
                  $("#cbcperfomancetable").html('');

                  if (res.schoolsystem == "CBC") {
                    if (res.cbcassessments.length == 0) {
                      $("#cbcperfomancetable").html('<h6 class="text-danger">No Assessments recorded</h6>');
                    } else {
                      $.each(res.cbcassessments, function(key,item){
                            var html = "";
                            html += '<tr>';
                            html += '<td>'+item.Assessment+'</td>';
                            html += '<td>'+item.Type+'</td>';
                            html += '<td><a class="btn btn-sm btn-success" href="/cbc-student-perfomance/{{ $student["id"] }}/'+item.id+'">Analyze</a></td>';
                            html += '</tr>';

                            $("#cbcperfomancetable").append(html);
                    }); 
                    }
                  } else {
                  if (res.scores.length == 0) {
                    $("#perfomancetable").html('<h6 class="text-danger">The student does not have any examination records</h6>');
                  } else {
                    //console.log(res);
                    var dataarray1 = [];
                    var dataarray2 = [];

                    res.threads.forEach((thread, index) => {
                      dataarray1.push([(thread+','+res.terms[index]+','+res.years[index]), parseFloat(res.strpositions[index]), parseFloat(res.ovpositions[index])]);
                    });

                    res.threads.forEach((thread, index) => {
                      dataarray2.push([(thread+','+res.terms[index]+','+res.years[index]), parseFloat(res.scores[index])]);
                    });

                    google.charts.setOnLoadCallback(drawpositionalChart(dataarray1));
                    google.charts.setOnLoadCallback(drawperfomanceChart(dataarray2));

                    for (let i = 0; i < res.threads.length; i++) {
                      var html = "";
                      html += '<tr>';
                      html += '<td><b>'+res.threads[i]+'-'+res.terms[i]+'-'+res.years[i]+'</b></td>';
                      html += '<td>'+res.scores[i]+'</td>';
                      html += '<td>'+res.grades[i]+'</td>';
                      html += '<td>'+res.ovpositions[i]+'</td>';
                      html += '<td>'+res.strpositions[i]+'</td>';
                      html += '<td><a class="btn btn-sm btn-danger" href="/student-perfomance/{{ $student["id"] }}/'+res.threadids[i]+'">Analyze</a></td>';
                      html += '</tr>';

                      $("#perfomancetable").append(html);
                    }
                  } 
                } 
                }                   
        })
    }
    
})
</script>
@endsection