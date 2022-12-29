@extends('layouts.layout')

@section('title','Terms')

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
<h4>Set Curent Term For Each Class</h4>
<div class="container">
    <div class="row d-flex justify-content-center align-item-center border border-1 border-success p-2">
        <div class="col-lg-6 border-success border-1 p-2">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Class</th>
                            <th scope="col">Current Term</th>
                        </tr>
                    </thead>
                    <tbody id="currenttermtable">
                        @if(count($classes) ==0)
                        <tr>
                            <td><h6 class="text-danger">There are currently no books in the database</h6></td>
                        </tr>
                        @else
                        @foreach($classes as $class)
                         <tr>
                             @if($class->current_term == null)
                                <td>{{ $class->class }} {{ $class->stream }}</td>
                                <td>Not Set</td>
                             @else
                                <td>{{ $class->class }} {{ $class->stream }}</td>
                                <td><button class="btn btn-sm btn-info">{{ $class->current_term }}</button></td>
                             @endif
                         </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6 border border-danger border-1 p-2">
            <form id="updatecurrentterm" method="POST" action="#">
            <div id="response"></div>
                <div class="form-group">
                    <label for=""><h6 class="text-danger text-center">Select Class To Set Current Term</h6></label>
                    <select class="form-control" name="class" id="class">
                        <option value="">--Select Class--</option>
                        @foreach($classes as $class)
                         <option value="{{ $class->class }} {{ $class->stream }},{{ $class->id }}">{{ $class->class }} {{ $class->stream }}</option>
                         @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div id="updatediv" class="row d-none">
                    <div id="cterm" class="col-lg-6 p-2 d-none w3-animate-left">

                    </div>
                    <div id="fetchedtermscontainer" class="col-lg-6 d-none w3-animate-right">
                        <div id="fetrchedterms" class="form-group">

                        </div>
                    </div>
                    <div class="invalidfeedback d-none text-center text-danger"></div>
                    <div class="form-group mt-2 d-grid">
                     <input class="btn btn-sm btn-success rounded-0" type="submit" value="SET TERM">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@section('script')
<script>
function preview(){
        frame.src=URL.createObjectURL(event.target.files[0]);
        }
</script>
<script>
    $(document).ready(function(){
            //fetch Classes
            function fetchTerms2(){
                $.ajax({
                method: 'GET',
                url: '/fetchterms',
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                  $('#currenttermtable').html('');
                  $.each(res.classes, function(key,item){
                      if (item.current_term == null) {
                        $('#currenttermtable').append('<tr>\
                        <td>'+item.class+' '+item.stream+'</td>\
                        <td>Not Set</td>\
                        </tr>'); 
                      } else {
                        $('#currenttermtable').append('<tr>\
                        <td>'+item.class+' '+item.stream+'</td>\
                        <td><button class="btn btn-sm btn-info">'+item.current_term+'</button></td>\
                        </tr>');  
                      }
                    
                  })  
                } 
                })
            }

            function fetchTerms(classname){
            $.ajax({
                method: 'GET',
                url: `/fetchterm/${classname}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    $('#updatediv').removeClass('d-none');
                    $('#fetrchedterms').html('');
                    $('#cterm').html('');
                    $('#fetchedtermscontainer').removeClass('d-none');
                    $('#cterm').removeClass('d-none');
                    if (res.cterm == null) {
                        $('#cterm').append('<h6 class="text-center text-success">Current Term Not Yet Set</h6>');  
                    } else {
                      $('#cterm').append('<h6 class="text-center text-danger">Current Term : '+res.cterm+'</h6>');   
                    }
                    if (res.terms.length == 0) {
                        $('#fetrchedterms').append('<h6 class="text-danger m-2">Terms not yet set. Click <a href="/terms">This Link</a> to set terms</h6>')
                    } else {
                        $.each(res.terms, function(key,item){
                            if (res.cterm == item.term) {
                                $('#fetrchedterms').append('<input id="term" checked class="w3-radio" type="radio" name="term" value="'+item.term+'"><label class="w3-validate">'+item.term+'</label>')  
                            } else {
                                $('#fetrchedterms').append('<input id="term" class="w3-radio" type="radio" name="term" value="'+item.term+'"><label class="w3-validate">'+item.term+'</label>')           
                            }
                        
                    })   
                    }
                    
                }
                 })
            }

          //Update current term ajax
            $('#updatecurrentterm').submit(function(e){
                e.preventDefault();
                var formdata = new FormData($(this)[0]);
                $.ajax({
                    method: 'POST',
                    url: '/updatecurrentterm',
                    contentType: false,
                    processData: false,
                    //dataType: 'json',
                    data: formdata,
                    success: function(res){
                        if (res.status == 400) {
                            $('.invalidfeedback').removeClass('d-none')
                            $('.invalidfeedback').html(res.messages.term)
                            showError('class', res.messages.class);
                        } else if(res.status == 200){
                            $('#updatecurrentterm')[0].reset();
                            $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>') 
                            fetchTerms2()
                        }
                    }
                })
            })

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#class').change(function(e){
            e.preventDefault();
            $('#fetchedtermscontainer').addClass('d-none');
            $('#cterm').addClass('d-none');
            var value = $(this).val()
            var arr = [value];
            fetchTerms(value)
        })
    
    }) 
</script>

@endsection