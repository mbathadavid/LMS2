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
<h4>Exam Result Threads</h4>
<div class="mb-2">
<button class="btn btn-sm w3-yellow" data-bs-toggle="modal" data-bs-target="#threadaddModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD RESULT THREAD</button>
</div>


<div id="response"></div>
<div class="row justify-content-center align-items-center">
    <div class="col-lg-8 col-md-8 col-sm-10">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Exam Threads</th> 
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="threadstable">
            
        </tbody>
        </table>
    </div>

        </div>

<!---Exam Thread modal start--->
<div id="threadaddModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">ADD RESULT THREAD MODAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="resultthreadmodal">
        <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" hidden>
            <div class="form-group">
            <label for="" class="text-bold text-success">Name of Results e.g MID-TERM-RESULTS, END-TERM-RESULTS</label> 
            <input placeholder="e.g MID-TERM-RESULTS" type="text" name="resultsname" id="resultsname" class="form-control"> 
            <div class="invalid-feedback"></div>
        </div>
           <div class="form-group mb-2">
            <label for="" class="text-bold text-success">Term</label>
            <select name="term" id="term" class="form-control">
                <option value="">--Select Term--</option>
                <option value="Term One">TERM ONE</option>
                <option value="Term Two">TERM TWO</option>
                <option value="Term Three">TERM THREE</option>
            </select>
            <div class="invalid-feedback"></div>
           </div> 

           <div class="form-group mb-2">
           <label for="" class="text-bold text-success">Year</label>
            <input placeholder="e.g 2023" class="form-control" type="number" name="year" id="year">
            <div class="invalid-feedback"></div>
           </div>

        <div class="form-group d-grid">
            <input class="btn btn-primary btn-sm rounded-0" id="resultthreadbtn" type="submit" value="SUBMIT RESULT THREAD">
        </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!---Exam Thread modal End--->

<!----Edit Modal Start---->
<div id="threadeditModal" class="modal w3-animate-zoom" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">EDIT RESULT THREAD</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="resultthreadeditform">
        <input type="number" name="tid" id="tid" hidden>
            <div class="form-group">
            <label for="" class="text-bold text-success">Name of Results e.g MID-TERM-RESULTS, END-TERM-RESULTS</label> 
            <input placeholder="e.g MID-TERM-RESULTS" type="text" name="editresultsname" id="editresultsname" class="form-control"> 
            <div class="invalid-feedback"></div>
        </div>
           <div class="form-group mb-2">
            <label for="" class="text-bold text-success">Term</label>
            <select name="editterm" id="editterm" class="form-control">
                <option id="edterm">--Select Term--</option>
                <option value="Term One">TERM ONE</option>
                <option value="Term Two">TERM TWO</option>
                <option value="Term Three">TERM THREE</option>
            </select>
            <div class="invalid-feedback"></div>
           </div> 

           <div class="form-group mb-2">
           <label for="" class="text-bold text-success">Year</label>
            <input placeholder="e.g 2023" class="form-control" type="number" name="edityear" id="edityear">
            <div class="invalid-feedback"></div>
           </div>

        <div class="form-group d-grid">
            <input class="btn btn-primary btn-sm rounded-0" id="resultthreadeditbtn" type="submit" value="UPDATE RESULT THREAD">
        </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!----Edit Modal End---->


</div>   
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        fetchthreads()

        function fetchthreads(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchthreads/${sid}`,
                success: function(res){
                    //console.log(res.threads)
                    if (res.threads == 0) {
                        $('#threadstable').html('<h5 class="text-center text-danger">No any Exam Threads Registered as at now</h5>');
                    } else {
                        $('#threadstable').html('');
                        $.each(res.threads, function(key,item){
                            $('#threadstable').append('<tr>\
                                <td><input value="'+item.id+'" type="checkbox" class="checkboxid" name="threadcheckbox" id="threadcheckbox"></td>\
                                <td>'+item.term+' '+item.year+' '+item.name+'</td>\
                                <td><button value='+item.id+' class="btn btn-success btn-sm" id="editbtn"><i class="fas fa-edit"></i>Update</button>&nbsp;<button value='+item.id+' class="btn btn-danger btn-sm" id="deletebtn"><i class="fas fa-trash"></i>Delete<td>\
                            </tr>');
                        })
                    }
                } 
                })
                
            }
        //Submit Results Thread
        $('#resultthreadmodal').submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0])

            $.ajax({
             method: 'POST',
             url: '/registerthread',
             contentType: false,
             processData: false,
             //dataType: 'json',
             data: formData,
            success: function(res) {
                if (res.status == 400) {
                    showError('resultsname', res.messages.resultsname);
                    showError('year', res.messages.year);
                    showError('term', res.messages.term);
                } else if(res.status == 200){
                    fetchthreads()
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#resultthreadmodal')[0].reset();
                   $("#threadaddModal").modal('hide'); 
                }
            }
            })
        })

        //Edit Button
        $(document).on('click', '#editbtn', function(e){
            //e.preventDefault()
            var editval = $(this).val();
            $.ajax({
                method: 'GET',
                url: `/fetchthread/${editval}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    $('#tid').val(res.resulthread.id)
                    $('#editresultsname').val(res.resulthread.name)
                    $('#edterm').val(res.resulthread.term)
                    $('#edterm').text(res.resulthread.term)
                    $('#edityear').val(res.resulthread.year)
                    $('#threadeditModal').modal('show');
                   
                    }
                })
        })
        //Edit Thread form submission Ajax
        $('#resultthreadeditform').submit(function(e){
            e.preventDefault();
            removeValidationClasses($('#resultthreadeditform'))
            var formData = new FormData($(this)[0])

            $.ajax({
             method: 'POST',
             url: '/editthread',
             contentType: false,
             processData: false,
             //dataType: 'json',
             data: formData,
            success: function(res) {
                if (res.status == 400) {
                    showError('editresultsname', res.messages.editresultsname);
                    showError('editterm', res.messages.editterm);
                    showError('edityear', res.messages.edityear);
                } else if(res.status == 200){
                    fetchthreads()
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#resultthreadeditform')[0].reset();
                   $("#threadeditModal").modal('hide'); 
                }
            }
            })
        })
        //Delete Thread ajax request
        $(document).on('click', '#deletebtn',function(e){
         e.preventDefault();
         var deleteid = $(this).val();
        var confirm = window.confirm(`Are you sure you want to delete this Student? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deletethread/${deleteid}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                    fetchthreads()
                   if (res.status == 200) {
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
     })
    })
</script>
@endsection