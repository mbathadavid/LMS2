@extends('layouts.layout')

@section('title','My Assessment Perfomance')

@section('content')
    
    
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Students.sidebar')
</div>
<div id="main" class="maincontent">
@include('Students.topnav')
<div class="row justify-content-center align-items-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="table-responsive">
        <h6 class="text-center w3-grey p-2">{{ $cbcassessment['Assessment'] }} <span class="">({{ $cbcassessment['Type'] }})</span></h6>
        <h6 class="text-center">Name : <span class="text-danger"><b>{{ $student['Fname'] }} {{ $student['Lname'] }}</b></span></h6>
        <h6 class="text-center">Admission No : <span class="text-danger"><b>{{ $student['AdmissionNo'] }}</b></span></h6>
        <h6 class="text-center">UPI No : <span class="text-danger"><b>{{ $student['UPI'] }}</b></span></h6>
        <table class="table">
            <thead>
                <tr class="w3-green">
                    <th scope="col">Subject</th>
                    <th scope="col">Score</th> 
                    <th scope="col">Grade</th> 
                    <th scope="col">Remarks</th>   
                </tr>
            </thead>
            <tbody>
                @foreach ($studentmarks as $studentmark)
                    <tr>
                        <td>{{ $studentmark['subject'] }}</td>
                        <td>{{ $studentmark['marks'] }} / {{ $studentmark['maxscore'] }}</td>
                        <td>{{ $studentmark['Grade'] }}</td>
                        <td>{{ $studentmark['Remarks'] }}</td>
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



@section('script')
<script type="text/javascript">

</script>
@endsection