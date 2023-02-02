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
<h6 class="w3-red p-2 mb-0 text-center"><b>{{ $class }}</b> <b>{{ $subject }}</b> Student Scores</h6>
<table class="table">
<thead>
    <tr class="w3-green">
        <th scope="col">Admission/UPI No</th>
        <th scope="col">Name</th>
        @for ($i = 0; $i < count(explode(',',$availablescores)); $i++)
            <th scope="col">{{ explode(',',$availablescores)[$i] }}</th>
        @endfor

        <th scope="col">Score</th>
        <th scope="col">Grade</th>
    </tr>
        </thead>
        <tbody>
            @foreach ($grades as $key => $grade)
                <tr>
                    <td>{{ $grade['AdmissionNo'] }}</td>
                    <td>{{ $grade['FName'] }} {{ $grade['Lname'] }}</td>
                    @for ($i = 0; $i < count(explode(',',$grade['scores'])); $i++)
                        <td>{{ explode(',',$grade['scores'])[$i] }}</td>
                    @endfor
                    <td>{{ $grade['score'] }}</td>
                    <td>{{ $grade['grade'] }}</td>
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