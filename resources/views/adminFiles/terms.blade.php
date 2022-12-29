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
<h4>Terms(s)</h4>
<div class="container">
<div class="row">
    <div class="container border border-dark border-2 p-2">
        <form id="termform" action="#" method="POST">
            <div id="response" class="d-none"></div>
            <div class="d-flex">
            <div class="form-group m-2 w-50">
                <label for="">Class</label>
                <select class="form-control" name="class" id="class">

                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group m-2 w-50">
                <label for="">Term e.g TERM 1</label>
                <input class="form-control" type="text" name="term" id="term">
                <div class="invalid-feedback"></div>
            </div>
            </div>
            <div class="d-grid">
                <input id="termbtn" class="btn btn-success rounded-0" type="submit" value="ADD TERM">
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="table-responsive">
    <table class="table">
            <thead>
            <tr>
                <th scope="col">Class</th>
                <th scope="col">Terms</th>
            </tr>
        </thead>
        <tbody id="termstable">
            @foreach($classes as $class)
            <tr class="border border-info border-2">
               <td>{{ $class->class }} {{ $class->stream }}</td> 
               <td>
                   <table class="table">
                       <thead>
                       <tr>
                           <th scope="col">Terms</th>
                       </tr>
                       </thead>
                       <tbody>
                        <tr>
                                @foreach($terms as $term)
                                    @if($term->class == "$class->class $class->stream")
                                    <td>{{ $term->term }}</td>
                                    @endif
                                @endforeach
                        </tr>
                       </tbody>

                   </table>
               </td>
            </tr>
            @endforeach
        </tbody>
        </table>
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
        fecthclasses()

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    //function to fetch terms
    /*    function fetchTerms(){
            $.ajax({
                method: 'GET',
                url: '/fetchterms',
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                  $('#termstable').html('');
                  $.each(res.data.classes,function(key,item1){
                      $('#termstable').append('<tr class="border border-info border-2">\
                      <td>'+item1.class+' '+item1.stream+'</td>\
                      <td>\
                    <table class="table">\
                       <thead>\
                       <tr>\
                           <th scope="col">Terms</th>\
                       </tr>\
                       </thead>\
                       <tbody>\
                        <tr>\
                        $.each(res.data.terms,function(key,item){\
                            if (item.class == 'item1.class item1.stream') {\
                                <td>item1.term</td>\
                            }\
                        })\ 
                        </tr>\
                       </tbody>\
                   </table>\
               </td>\
                      </tr>')
                  })  
                }
            })
        } */

    //fetch students
    function fecthclasses(){
            $.ajax({
                method: 'GET',
                url: '/fetchclasses',
                //dataType: 'jsons',
                success: function(res) {
                    $('#class').html('');
                    $.each(res.classes, function(key,item){
                        $('#class').append('<option value="'+item.class+' '+item.stream+'">'+item.class+' '+item.stream+'</option>')
                    })
                }
                })
            }
        //Submit term form ajax
        $('#termform').submit(function(e){
            e.preventDefault();
            $('#termbtn').val('PLEASE WAIT...');
            var formdata = new FormData($(this)[0])
            $.ajax({
               method: 'POST',
               url: '/addterm',
               contentType: false,
               processData: false,
                //dataType: 'json',
              data: formdata, 
              success: function(res){
                if (res.status == 200) {
                    //fetchTerms()
                    $('#termbtn').val('ADD TERM');
                    $('#response').removeClass('d-none');
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#termform')[0].reset();
                } else if(res.status == 400){
                    $('#termbtn').val('ADD TERM');
                    showError('class', res.messages.class);
                    showError('term', res.messages.term);
                }
              }
            });
        })
    }) 
</script>

@endsection