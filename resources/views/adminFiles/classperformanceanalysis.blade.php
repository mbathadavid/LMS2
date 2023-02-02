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
<div class="table-responsive">
<table class="table">
<thead>
    <tr class="w3-green">
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

})
</script>
@endsection