@extends('layouts.layout')

@section('title','DashBoard')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">
@include('adminFiles.motto')
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

<!-------->

<!-------->

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
            $.ajax({
                method: 'GET',
                url: '/fetchthreads',
                success: function(res){
                    if (res.threads == 0) {
                        console.log('Nothing yet')
                    } else {
                        console.log(res.threads)
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
        
    })
</script>
@endsection