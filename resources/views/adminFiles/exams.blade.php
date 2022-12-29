@extends('layouts.layout')

@section('title','Examinations')

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
<h4>Examination(s)</h4>
<div class="mb-2">
<button class="btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#examaddModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD NEW EXAM</button>
<button class="btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#CBCModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD NEW CBC ASSESSMENT</button>
</div>
<!---Exams modal start-->
<div id="examaddModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">ADD EXAM MODAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="examregisterform">
        <div class="row">
            <div class="col-lg-6">
            <input hidden type="number" name="sid" id="sid" value="{{ session()->get('schooldetails.id') }}">
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Name the exam e.g Exam 1, Opening Exam, CAT 1 etc</h6></label>
                <input placeholder="Exam Name e.g Opening Exam" class="form-control" type="text" name="examname" id="examname">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Examination Year e.g 2022</h6></label>
                <input placeholder="Exam Year" class="form-control" type="number" name="year" id="year">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Term e.g Term 1</h6></label>
                <select class="form-control" name="term" id="term">
                 <option value="">--Examination Term--</option>
                 <option value="Term 1">Term 1</option>
                 <option value="Term 2">Term 2</option>
                 <option value="Term 3">Term 3</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Exam Type</h6></label>
                <select class="form-control" name="examtype" id="examtype">
                 <option value="">--Select Type of Examination--</option>
                 <option value="CAT">Continous Assessment Test</option>
                 <option value="Main Exam">Main Exam</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            </div>
            <div class="col-lg-6 border border-danger border-1 mb-2">
            <div>
            <h6 class="text-danger">Select all the classes that should subscribe to this exam</h6>
            <div class="table-responsive" style="max-height: 200px;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><th scope="col"><input type="checkbox" id="CheckAll"></th></th>
                        <th scope="col">Class</th> 
                    </tr>
                    </thead>
                        <tbody id="classsestable">

                        </tbody>
                    </table>
                    </div>
                    <div id="classesres" class="text-danger"></div>
            </div>
            </div>

            <div class="form-group d-grid">
             <input class="btn btn-primary btn-sm rounded-0" id="examsubmitbtn" type="submit" value="SUBMIT EXAM">
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!---Exams modal End--->

<!---Exams Edit modal start-->
<div id="exameditModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">EDIT EXAM MODAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="exameditform">
        <div class="row">
            <div class="col-lg-6">
                <input type="number" name="examid" id="examid" hidden>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Name the exam e.g Exam 1, Opening Exam, CAT 1 etc</h6></label>
                <input placeholder="Exam Name e.g Opening Exam" class="form-control bg-info" type="text" name="exameditname" id="exameditname">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Examination Year e.g 2022</h6></label>
                <input placeholder="Exam Year" class="form-control bg-info" type="number" name="edityear" id="edityear">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Term e.g Term 1</h6></label>
                <select class="form-control bg-info" name="editterm" id="editterm">
                 <option id="edittermval"></option>
                 <option value="Term 1">Term 1</option>
                 <option value="Term 2">Term 2</option>
                 <option value="Term 3">Term 3</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Exam Type</h6></label>
                <select class="form-control bg-info" name="examedittype" id="examedittype">
                 <option id="examedittypeval"></option>
                 <option value="CAT">Continous Assessment Test</option>
                 <option value="Main Exam">Main Exam</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            </div>
            <div class="col-lg-6 border border-danger border-1 mb-2">
            <div>
            <h6 class="text-danger">Select all the classes that should subscribe to this exam</h6>
            <div class="table-responsive" style="max-height: 200px;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><th scope="col"><input type="checkbox" id="CheckAll"></th></th>
                        <th scope="col">Class</th> 
                    </tr>
                    </thead>
                        <tbody id="classsesedittable" class="bg-success">

                        </tbody>
                    </table>
                    </div>
                    <div id="classeedit" class="text-danger"></div>
            </div>
            </div>

            <div class="form-group d-grid">
             <input class="btn btn-warning btn-sm rounded-0" id="exameditbutton" type="submit" value="EDIT EXAM">
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!---Exams edit modal End--->

<!---Exams view Modal Start--->
<div id="examviewModal" class="modal w3-animate-zoom" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success text-center" id="examtitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="row">
        <div class="col-lg-6">
            <h6> Exam : <span class="text-danger" id="viewexam"></span></h6>
            <h6> Exam Type : <span class="text-danger" id="viewexamtype"></span></h6>
            <h6> Year : <span class="text-danger" id="viewexamyear"></span></h6>
            <h6> Term : <span class="text-danger" id="viewexamterm"></span></h6>
        </div>
        <div class="col-lg-6">
            <div class="table-responsive">
                <table class="table" style="max-height: 50px;">
                    <thead>
                        <tr>
                            <th scope="col">Classes Taking The Exam</th>
                        </tr>
                    </thead>
                    <tbody id="viewclasses">

                    </tbody>
                </table>
            </div>
        </div>
       </div>
      </div>
    </div>
  </div>
</div>
<!---Exams view Modal End--->
    <div class="m-2 p-2 border border-success border-1">
    <div class="table-responsive">

        <div class="row d-none resultscomputation">
            <form action="#" id="computeresults">
                <input type="number" name="examresid" id="examresid" hidden>
                <div class="form-group mb-1">
                    <label for="">Select Class For Results Computation</label>
                    <select name="class" id="classtocompre" class="form-control">
                     <option value="">--Select Class--</option>
                    </select>
                </div>
                <div class="form-group mb-1 d-grid">
                    <input value="PROCEED TO COMPUTE RESULTS" type="submit" class="btn btn-sm btn-primary"> 
                </div>
                <button id="hideresultscompbtn" class="btn btn-sm btn-danger float-end">CANCEL</button>
            </form>
            <hr>
        </div>


    <div id="response"></div>
    <div class="row">
    <div id="actionbtns" class="mb-2 d-none">
        <button id="compresultsbtn" class="btn btn-sm btn-primary float-end m-1">Add Marks</button>
        <button id="examviewbtn" class="btn btn-sm btn-success float-end m-1"><i class="fas fa-eye"></i>&nbsp;View</button>
        <button id="exameditbtn" type="button" class="btn btn-sm btn-warning float-end m-1"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
        <button id="examdeletebtn" class="btn btn-sm btn-danger float-end m-1"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-11">
            <h6 class="bg-warning text-center p-2">8-4-4 Examinations</h6>
        <table class="table" id="table">
            <thead>
            <tr>
                <th scope="col"><input type="checkbox" id="CheckAll"></th>
                <th scope="col">Examination</th>
                <th scope="col">Exam Type</th>
                <th scope="col">Year</th>
                <th scope="col">Term</th>
            </tr>
        </thead>
        <tbody id="examstable">
        
        </tbody>
        </table>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-11">
        <h6 class="bg-success text-center p-2">CBC Assessments</h6>
        </div>
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
        fecthclasses1()
        exams()
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    
        //CheckAll
        $('#CheckAll').click(function(){
            if ($(this).is(':checked')) {
                $('#examcheckbox').prop('checked',true);
            } else {
                $('#examcheckbox').prop('checked',false);
            }
        })

        //function to fetchclasses
        function fecthclasses1(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            var etype = "8-4-4";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses2/${sid}/${etype}`,
                success: function(res){
                   $("#classsestable").html('')
                    $.each(res.classes, function(key,item){
                    $("#classsestable").append('<tr>\
                    <td><input value="'+item.id+'" id="classcheckbox" type="checkbox" name="classcheckbox"></td>\
                    <td>'+item.class+' '+item.stream+'</td>\
                    </tr>'); 
                })
                }
            });
        }

        //function to fetchclasses
        function fecthclasses2(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            var etype = "8-4-4";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses2/${sid}/${etype}`,
                success: function(res){
                    console.log(res.exams)
                   $("#classsesedittable").html('')
                    $.each(res.classes, function(key,item){
                    $("#classsesedittable").append('<tr>\
                    <td><input value="'+item.id+'" id="exameditcheckbox" type="checkbox" name="exameditcheckbox"></td>\
                    <td>'+item.class+' '+item.stream+'</td>\
                    </tr>');
                })
                }
            })
        }

        //function to fetchexams
        function exams(){
            var sid = "{{ session()->get('schooldetails.id') }}"
            $.ajax({
                method: 'GET',
                url: `/fetchexams/${sid}`,
                success: function(res){
                    console.log(res)
                    if (res.exams.length == 0) {
                        $('#examstable').html('<h5 class="text-danger">There are no classes registered yet</h5>')
                    } else {
                        $('#examstable').html('')
                        $.each(res.exams, function(key,item){
                            $('#examstable').append('<tr>\
                            <td><input value="'+item.id+'" type="checkbox" name="" id="examcheckbox"></td>\
                            <td>'+item.Examination+'</td>\
                            <td>'+item.ExamType+'</td>\
                            <td>'+item.Year+'</td>\
                            <td>'+item.Term+'</td>\
                        </tr>')
                        })
                    }
                }
            });
        }
        //Register Exam Ajax Request
        $("#examregisterform").submit(function(e){
            e.preventDefault();
            $('#examsubmitbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#examregisterform')[0]);
            
            var classes = [];
            $('#classcheckbox:checked').each(function(i){
                classes[i] = $(this).val()
            })  
           formData.append('classes', classes);

            $.ajax({
                method: 'POST',
                url: '{{ route('exam.register') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   if (res.status == 400) {
                    $('#examsubmitbtn').val('SUBMIT EXAM');
                    showError('examname', res.messages.examname);
                    showError('year', res.messages.year);
                    showError('term', res.messages.term);
                    showError('examtype', res.messages.examtype);
                    $('#classesres').html(res.messages.classes);
                   } else if(res.status == 200){
                    exams();
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#examregisterform')[0].reset();
                    $('#examsubmitbtn').val('SUBMIT EXAM');
                    $('#regresponse').text(res.messages)
                   $("#examaddModal").modal('hide'); 
                   }   
               }
            });
        })
        //Navigate to compute exam results
        $("#computeresults").submit(function(e){
            e.preventDefault();
            var classid = $('#classtocompre').val()
            var examid = $('#examresid').val();
            var sid = "{{ session()->get('schooldetails.id') }}" 
            window.location = `/classresults/${examid}/${classid}/${sid}`;
        })

        //Edit exam ajax Request
        $("#exameditform").submit(function(e){
            e.preventDefault();
            $('#exameditbutton').val('PLEASE WAIT...');
            var formData = new FormData($('#exameditform')[0]);
            
            var classes = [];
            $('#exameditcheckbox:checked').each(function(i){
                classes[i] = $(this).val()
            })  
           formData.append('classes', classes);

            $.ajax({
                method: 'POST',
                url: '{{ route('exam.edit') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   console.log(res)
                   if (res.status == 400) {
                    $('#exameditbutton').val('EDIT EXAM');
                    //showError('exameditname', res.messages.exameditname);
                    showError('exameditname', res.messages.examname);
                    showError('edityear', res.messages.year);
                    showError('editterm', res.messages.term);
                    showError('examedittype', res.messages.examtype);
                    $('#classeedit').html(res.messages.classes);
                   } else if(res.status == 200){
                    exams();
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#exameditform')[0].reset();
                    $('#exameditbutton').val('EDIT EXAM');
                    $('#regresponse').text(res.messages)
                   $("#exameditModal").modal('hide'); 
                   }   
               }
            });
        })

        //handle selection of books
     $(document).on('change', '#examcheckbox',function(e){
        e.preventDefault();
        $('#actionbtns').removeClass('d-none');
     })

     //function to fetch details of a exam for update
    function fetchexam2(id){
        $.ajax({
                method: 'GET',
                url: `/getExam/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.exam;
                    $('#examid').val(data.id)
                    $('#edityear').val(data.Year);
                    $('#exameditname').val(data.exam);
                    $('#edittermval').text(data.Term);
                    $('#edittermval').val(data.Term);
                    $('#examedittypeval').val(data.ExamType);
                    $('#examedittypeval').text(data.ExamType); 
                }
            })
        }
    //Function to fetch exam for viewing
    function fetchexam3(id){
        $.ajax({
                method: 'GET',
                url: `/getExam/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.exam;
                    $('#examtitle').text(data.Examination)
                    $('#viewexam').text(data.exam)
                    $('#viewexamtype').text(data.ExamType)
                    $('#viewexamyear').text(data.Year)
                    $('#viewexamterm').text(data.Term)
                    $('#viewclasses').html('')
                    //console.log(data.classnames.split(','))
                    for (let i = 0; i < data.classnames.split(',').length; i++) {
                        $('#viewclasses').append('<tr>\
                        <td>'+data.classnames.split(',')[i]+'</td>\
                        </tr>')
                    }                    
                }
            })
        }
        //function to fetchclasses
        function fecthclasses(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            var etype = "8-4-4";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses2/${sid}/${etype}`,
                success: function(res){
                    console.log(res)
                    if (res.classes.length == 0) {
                        $('#classtocompre').text('Sorry!There are no classes added recently')
                    } else {
                        $('#classtocompre').html('');
                        $('#classtocompre').append('<option value="">Select Class</option>');
                        $.each(res.classes, function(key,item){
                            $('#classtocompre').append('<option value="'+item.id+'">'+item.class+' '+item.stream+'</option>')
                        })
                    }
                }
            });
        }
     //Book deleting ajax
     $(document).on('click', '#examdeletebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#examcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select exam(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this exam? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deleteexam/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    exams();
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#response').text('Sorry!Something went wrong while deleting.Please try again later');  
                   }
                    }
                }) 
            }  
        }
     })
     //Handle exam editing
     $(document).on('click', '#exameditbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#examcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select an exam to edit');
        } else if(ids.length > 1){
            alert('You can only edit one exam at a time. Select only one Book');
        } else {
            fetchexam2(ids)
            fecthclasses2()
           $('#exameditModal').modal('show'); 
        }
     })
     //Handle Exam Viewing
     $(document).on('click', '#examviewbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#examcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select an exam to view details');
        } else if(ids.length > 1){
            alert('You can only view one Exam at a Time');
        } else {
            fetchexam3(ids)
           $('#examviewModal').modal('show'); 
        }
     })

     //Handle hiding
     $(document).on('click', '#hideresultscompbtn',function(e){
         e.preventDefault();
         $('.resultscomputation').addClass('d-none');
     })

     //Handle Results Computation
     $(document).on('click', '#compresultsbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#examcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select an exam for which results are to be computed');
        } else if(ids.length > 1){
            alert('You can only compute results of one class at a time.');
        } else {
           $('#examresid').val(ids)
           $('.resultscomputation').removeClass('d-none'); 
           fecthclasses()
        }
     })

    }) 
</script>

@endsection