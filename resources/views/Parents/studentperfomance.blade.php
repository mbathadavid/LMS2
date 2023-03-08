@extends('layouts.layout')

@section('title','Student Perfomance')

@section('content') 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Parents.sidebar')
</div>
<div id="main" class="maincontent">
@include('Parents.topnav')
<div class="row justify-content-center align-items-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="table-responsive">
            <h5 class="text-center w3-grey p-2">{{ $resultthread['name'] }},{{ $resultthread['year'] }},{{ $resultthread['term'] }}</h5>
            <h6 class="text-center">Name : <span class="text-danger">{{ $student['Fname'] }} {{ $student['Lname'] }}</span></h6>
            <h6 class="text-center">Admission Number : <span class="text-danger">{{ $student['AdmissionNo'] }}</span></h6>
            <h6 class="text-center">UPI Number : <span class="text-danger">{{ $student['UPI'] }}</span></h6>
            <hr>
            <h6 class="text-center">Score : <span class="text-danger">{{ $examscores['Finalscore'] }}</span></h6>
            <h6 class="text-center">Grade : <span class="text-danger">{{ $examscores['Finalgrade'] }}</span></h6>
            <h6 class="text-center">Class Position : <span class="text-danger">{{ $examscores['OVRPO'] }}</span></h6>
            <h6 class="text-center">Stream Position : <span class="text-danger">{{ $examscores['STRPOS'] }}</span></h6>
            <hr>
            <table class="table">
                <thead>
                <tr class="w3-green">
                    <th scope="col">Subject</th>
                    <th scope="col">Score (Marks)</th>
                    <th scope="col">Score (Points)</th>
                    <th scope="col">Grade</th> 
                </tr>
            </thead>
            <tbody>
                @for($i=0; $i < count(explode(',',$examscores['ScoresByPoints'])); $i++)
                    <tr>
                        <td>{{ explode(',',$examscores['Subjects'])[$i] }}</td>
                        <td>{{ explode(',',$examscores['ScoresByMarks'])[$i] }}</td>
                        <td>{{ explode(',',$examscores['ScoresByPoints'])[$i] }}</td>
                        <td>{{ explode(',',$examscores['Grades'])[$i] }}</td>
                    </tr>
                @endfor
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