@extends('layouts.layout')

@section('title','My Issued Books')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Students.sidebar')
</div>
<div id="main" class="maincontent">

@include('Students.topnav')
<div class="row justify-content-center align-items-center">
<div class="col-lg-8 col-md-8 col-sm-12">
<h6 class="text-center text-danger">Issued Books</h6>
@if (count($books) == 0)
<h3 class="text-center text-danger">You have no any issued books</h3>
@else
<!-- @for ($i = 0; $i < count(explode(',',session()->get('LoggedInUser.books'))); $i++)
<h6 class="text-center">{{ explode(',',session()->get('LoggedInUser.books'))[$i] }}</h6>
@endfor -->
@foreach ($books as $book)
<h5 class="text-center text-success">{{ $book['BookNumber'] }}, {{ $book['Category'] }}</h5>
@endforeach
@endif
</div>
</div>
 
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        //setting csrf token
        $.ajaxSetup({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


    })
</script>
@endsection