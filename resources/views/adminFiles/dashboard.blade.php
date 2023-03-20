@extends('layouts.layout')

@section('title','DashBoard')

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
@if(in_array(2,explode(',',session()->get('LoggedInUser.priviledges'))))
<div class="row justify-content-center mb-2">
<div class="col-lg-4 col-md-4 col-sm-4">
<div class="w3-green p-2">
<h6 class="text-center">Pending Fee Arrears</h6>
<h6 class="text-center">KSH. <b class="">{{ $pendingbalances }}</b></h6>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4">
<div class="w3-green p-2">
<h6 class="text-center">Current Term Balance</h6>
<h6 class="text-center">KSH. <b class="">{{ $currenttermbalances }}</b></h6>  
</div>   
</div>
<div class="col-lg-4 col-md-4 col-sm-4">
<div class="w3-green p-2">
<h6 class="text-center">Overall Balance</h6>
<h6 class="text-center">KSH. <b class="">{{ $pendingbalances+$currenttermbalances }}</b></h6>  
</div>   
</div>
<hr>
@endif

<div class="row justify-content-center mb-2">
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="w3-grey p-2">
<h6 class="text-center">Recorded CBC Assessments</h6>
<h6 class="text-center"><b>{{ $cbcassessments }}</b></h6>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="w3-grey p-2">
<h6 class="text-center">Recorded Examinations (8-4-4)</h6>
<h6 class="text-center"><b>{{ $resultthreads }}</b></h6>  
</div>   
</div>
<hr>
<!-- Display students div start -->
<div class="row text-light text-center font-weight-bold justify-content-center">
        <div class="col-lg-4">
        <div class="card w3-blue" style="height: auto">
          <div class="card-header"><h5><i class="fas fa-user-graduate"></i> Total Students</h5></div>
          <div class="card-body">
            <h1 class="display-4">Total {{ $totalstudents }}</h1>
            <h6 class="">Females <b>{{ $femalestudents }}</b></h6>
            <h6 class="">Males <b>{{ $malestudents }}</b></h6>
            <h6 class="">8-4-4 <b>{{ $oldsystemstudents }}</b></h6>
            <h6 class="">CBC <b>{{ $cbcstudents }}</b></h6>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>

        <div class="col-lg-4">
        <div class="card w3-blue" style="height: auto">
          <div class="card-header">Male to Female Proportion</div>
          <div class="card-body">
            <div id="malefemalestudents"></div>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>

        <div class="col-lg-4">
        <div class="card w3-blue" style="height: auto">
          <div class="card-header">8-4-4 to CBC Proportion</div>
          <div class="card-body">
            <div id="educationsystem"></div>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>
  </div>
<hr>
<!-- Display students div end -->

<!-- Display Teachers div start -->
<div class="row text-light text-center font-weight-bold justify-content-center">
        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card w3-red" style="height: auto">
          <div class="card-header"><h5><i class="fas fa-users"></i> Total Teachers</h5></div>
          <div class="card-body">
            <h1 class="display-4">Total {{ $teachers }}</h1>
            <h6 class="">Females <b>{{ $femaleteachers }}</b></h6>
            <h6 class="">Males <b>{{ $maleteachers }}</b></h6>
          </div>
          <div class="card-footer">
      
          </div>
        </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card w3-red" style="height: auto">
          <div class="card-header">Male to Female Proportion</div>
          <div class="card-body">
            <div id="malefemaleteachers"></div>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>
        
  </div>
<hr>
<!-- Display Teachers div end -->

<!-- Display Support Staff div start -->
<div class="row text-light text-center font-weight-bold justify-content-center">
        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card w3-indigo" style="height: auto">
          <div class="card-header"><h5><i class="fas fa-users"></i> Total Support Staff</h5></div>
          <div class="card-body">
            <h1 class="display-4">Total {{ $supportstaff }}</h1>
            <h6 class="">Females <b>{{ $femalestaff }}</b></h6>
            <h6 class="">Males <b>{{ $malestaff }}</b></h6>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card w3-indigo" style="height: auto">
          <div class="card-header">Male to Female Proportion</div>
          <div class="card-body">
            <div id="malefemalesupportstaff"></div>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>
        
  </div>
<hr>
<!-- Display Support Staff div end -->

<!-- Display Parents div start -->
<div class="row text-light text-center font-weight-bold justify-content-center">
        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card bg-info" style="height: auto">
          <div class="card-header"><h5><i class="fas fa-users"></i> Total Parents</h5></div>
          <div class="card-body">
            <h1 class="display-4">Total {{ $parents }}</h1>
            <h6 class="">Females <b>{{ $femaleparents }}</b></h6>
            <h6 class="">Males <b>{{ $maleparents }}</b></h6>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card bg-info" style="height: auto">
          <div class="card-header">Male to Female Proportion</div>
          <div class="card-body">
            <div id="malefemaleparent"></div>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>
        
  </div>
<hr>
<!-- Display Parents div end -->

<!-- Display Streams Start -->
<div class="row text-light text-center font-weight-bold justify-content-center">
        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card bg-success" style="height: auto">
          <div class="card-header"><h5><i class="fas fa-building"></i> Total Streams</h5></div>
          <div class="card-body">
            <h1 class="display-4">Total {{ $stream }}</h1>
            <h6 class="">8-4-4 Streams <b>{{ $oldsystemstream }}</b></h6>
            <h6 class="">CBC Streams <b>{{ $cbcstream }}</b></h6>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card bg-success" style="height: auto">
          <div class="card-header">CBC to 8-4-4 Stream Proportion</div>
          <div class="card-body">
            <div id="schoolsystemclasschart"></div>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>
        
  </div>
<hr>
<!-- Display Streams div end -->

<!-- Display Learning Resources div Start -->
<div class="row text-light text-center font-weight-bold justify-content-center">
        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card bg-danger" style="height: auto">
          <div class="card-header"><h5><i class="fas fa-book"></i> Total Books</h5></div>
          <div class="card-body">
            <h1 class="display-4">Total {{ $books }}</h1>
            <h6 class="">In Store <b>{{ $instorebooks }}</b></h6>
            <h6 class="">Borrowed <b>{{ $borrowedbooks }}</b></h6>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-10">
        <div class="card bg-danger" style="height: auto">
          <div class="card-header">In Store vs. Borrowed Books Proportion</div>
          <div class="card-body">
            <div id="bookschart"></div>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
        </div>
        
  </div>
<hr>
<!-- Display Learning Resources div end -->
    
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawgenderChart);
      google.charts.setOnLoadCallback(drawedusystemChart);
      google.charts.setOnLoadCallback(drawteacherChart);
      google.charts.setOnLoadCallback(drawsuppportstaffChart);
      google.charts.setOnLoadCallback(drawparentChart);
      google.charts.setOnLoadCallback(drawstreamChart);
      google.charts.setOnLoadCallback(drawbooksChart); 

      //Draw Gender Chart
      function drawgenderChart() {
        var total = {{ $malestudents }} + {{ $femalestudents }};
        var malepercentage = ({{ $malestudents }} / total) * 100;
        var femalepercentage = ({{ $femalestudents }} / total) * 100;
          var data = google.visualization.arrayToDataTable([
          ['Gender', 'Count'],
          ['Male', malepercentage],
          ['Female', femalepercentage]
        ]);

        var options = {
          title: 'Male to Female Student Proportion',
          curveType: 'function',
          is3D: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('malefemalestudents'));

        chart.draw(data, options);
      }

      //Draw CBC to 8-4-4 Chart
      function drawedusystemChart() {
        var total = {{ $malestudents }} + {{ $femalestudents }};
        var cbcstudents = ({{ $cbcstudents }} / total) * 100;
        var oldsystemstudents = ({{ $oldsystemstudents }} / total) * 100;
          var data = google.visualization.arrayToDataTable([
          ['School System', 'Count'],
          ['8-4-4', cbcstudents],
          ['CBC', oldsystemstudents]
        ]);

        var options = {
          title: 'CBC to 8-4-4 Student Proportion',
          curveType: 'function',
          is3D: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('educationsystem'));

        chart.draw(data, options);
      }

      //Draw Male to Female Teachers Pie Chart
      function drawteacherChart() {
        var total = {{ $maleteachers }} + {{ $femaleteachers }};
        var maleteachersper = ({{ $maleteachers }} / total) * 100;
        var femaleteachersper = ({{ $femaleteachers }} / total) * 100;
          var data = google.visualization.arrayToDataTable([
          ['Gender', 'Count'],
          ['Male', maleteachersper],
          ['Female', femaleteachersper]
        ]);

        var options = {
          title: 'Male to Female Teacher Proportion',
          curveType: 'function',
          is3D: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('malefemaleteachers'));

        chart.draw(data, options);
      }

      //Draw Support Staff Pie Chart
      function drawparentChart() {
        var total = {{ $femalestaff }} + {{ $malestaff }};
        var malestaffper = ({{ $malestaff }} / total) * 100;
        var femalestaffper = ({{ $femalestaff }} / total) * 100;
          var data = google.visualization.arrayToDataTable([
          ['Gender', 'Count'],
          ['Male', malestaffper],
          ['Female', femalestaffper]
        ]);

        var options = {
          title: 'Male to Female Support Staff Proportion',
          curveType: 'function',
          is3D: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('malefemalesupportstaff'));

        chart.draw(data, options);
      }

      //Draw Parent Pie Chart 
      function drawsuppportstaffChart() {
        var total = {{ $maleparents }} + {{ $femaleparents }};
        var maleparentsper = ({{ $maleparents }} / total) * 100;
        var femaleparentsper = ({{ $femaleparents }} / total) * 100;
          var data = google.visualization.arrayToDataTable([
          ['Gender', 'Count'],
          ['Male', maleparentsper],
          ['Female', femaleparentsper]
        ]);

        var options = {
          title: 'Male to Female Parent Proportion',
          curveType: 'function',
          is3D: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('malefemaleparent'));

        chart.draw(data, options);
      }

      //Draw Stream pie Chart 
      function drawstreamChart() {
        var total = {{ $cbcstream }} + {{ $oldsystemstream }};
        var cbcstreamper = ({{ $cbcstream }} / total) * 100;
        var oldsystemstreamper = ({{ $oldsystemstream }} / total) * 100;
          var data = google.visualization.arrayToDataTable([
          ['Stream', 'Count'],
          ['8-4-4', oldsystemstreamper],
          ['CBC', cbcstreamper]
        ]);

        var options = {
          title: '8-4-4 to CBC Stream Proportion',
          curveType: 'function',
          is3D: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('schoolsystemclasschart'));

        chart.draw(data, options);
      }

      //Draw Books Chart
      function drawbooksChart() {
        var total = {{ $borrowedbooks }} + {{ $instorebooks }};
        var borrowedbooksper = ({{ $borrowedbooks }} / total) * 100;
        var instorebooksper = ({{ $instorebooks }} / total) * 100;
          var data = google.visualization.arrayToDataTable([
          ['Books', 'Count'],
          ['Borrowed', borrowedbooksper],
          ['In Store', instorebooksper]
        ]);

        var options = {
          title: 'In Store to Borrowed Book Proportion',
          curveType: 'function',
          is3D: true,
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('bookschart'));

        chart.draw(data, options);
      }

    </script>
@endsection