@extends('layouts.layout')

@section('title','CBC Assessments')

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
<h6 class="text-danger">CBC Assessment(s)</h6>
<div class="mb-2">
<button class="btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#assessmentaddModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD NEW CBC ASSESSMENT</button>
</div>
<!---Exams view Modal Start--->
<div id="assessmentviewModal" class="modal w3-animate-zoom" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success text-center" id="examtitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="row justify-content-center align-items-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <h6> Assessment : <span class="text-danger" id="viewexam"></span></h6>
            <h6> Assessment Type : <span class="text-danger" id="viewexamtype"></span></h6>
            <h6> Year : <span class="text-danger" id="viewexamyear"></span></h6>
            <h6> Term : <span class="text-danger" id="viewexamterm"></span></h6>
        </div>
       </div>
      </div>
    </div>
  </div>
</div>
<!---Exams view Modal End--->

<!---Exams Edit modal start-->
<div id="assessmenteditModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">EDIT ASSESSMENT MODAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="assessmenteditform">
                <input type="number" name="assessmentid" id="assessmentid" hidden>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Name the Assessment e.g END-TERM ASSESSMENT</h6></label>
                <input placeholder="Assessment Name e.g END-TERM ASSESSMENT" class="form-control" type="text" name="exameditname" id="exameditname">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Examination Year e.g 2022</h6></label>
                <input placeholder="Exam Year" class="form-control" type="number" name="edityear" id="edityear">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Term e.g Term 1</h6></label>
                <select class="form-control" name="editterm" id="editterm">
                 <option id="edittermval"></option>
                 <option value="Term 1">Term 1</option>
                 <option value="Term 2">Term 2</option>
                 <option value="Term 3">Term 3</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Exam Type</h6></label>
                <select class="form-control" name="examedittype" id="examedittype">
                 <option id="examedittypeval"></option>
                 <option value="Classroom Assessment">Classroom Assessment</option>
                 <option value="School-based Assessment">School-based Assessment</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group d-grid">
             <input class="btn btn-warning btn-sm rounded-0" id="assessmenteditbutton" type="submit" value="EDIT ASSESSMENT">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!---Exams edit modal End--->

<!---Exams modal start-->
<div id="assessmentaddModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">ADD ASSESSMENT MODAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="assessmentregisterform">
            <input hidden type="number" name="sid" id="sid" value="{{ session()->get('schooldetails.id') }}">
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Name the Assessment e.g END-TERM-ASSESSMENT </h6></label>
                <input placeholder="Assessment Name e.g Opening Assessment" class="form-control" type="text" name="assessmentname" id="assessmentname">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Assessment Year e.g 2023</h6></label>
                <input placeholder="Assessment Year" class="form-control" type="number" name="year" id="year">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Term e.g Term 1</h6></label>
                <select class="form-control" name="term" id="term">
                 <option value="">--Assessment Term--</option>
                 <option value="Term 1">Term 1</option>
                 <option value="Term 2">Term 2</option>
                 <option value="Term 3">Term 3</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
              <label for=""><h6 class="text-success">Assessment Type</h6></label>
                <select class="form-control" name="assessmenttype" id="assessmenttype">
                 <option value="">--Select Type of Assessment--</option>
                 <option value="Classroom Assessment">Classroom Assessment</option>
                 <option value="School-Based Assessment">School-Based Assessment</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="form-group d-grid">
             <input class="btn btn-primary btn-sm rounded-0" id="assessmentsubmitbtn" type="submit" value="SUBMIT ASSESSMENT">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!---Exams modal End--->

<div id="response"></div>
<div id="actionbtns" class="mb-2">
        <button id="compresultsbtn" class="btn btn-sm btn-primary float-end m-1">Add Marks</button>
        <button id="examviewbtn" class="btn btn-sm btn-success float-end m-1"><i class="fas fa-eye"></i>&nbsp;View</button>
        <button id="exameditbtn" type="button" class="btn btn-sm btn-warning float-end m-1"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
        <button id="examdeletebtn" class="btn btn-sm btn-danger float-end m-1"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button>
</div>

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
                    <input value="PROCEED TO ADD MARKS" type="submit" class="btn btn-sm btn-primary"> 
                </div>
                <button id="hideresultscompbtn" class="btn btn-sm btn-danger float-end">CANCEL</button>
            </form>
            <hr>
        </div>


<div class="row justify-content-center align-items-center">
    <div class="col-lg-6 col-md-6 col-sm-12">
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
            <tr>
                <th scope="col"><input type="checkbox" id="CheckAll"></th>
                <th scope="col">Examination</th>
                <th scope="col">Assessment Type</th>
                <th scope="col">Year</th>
                <th scope="col">Term</th>
            </tr>
        </thead>
        <tbody id="assessmentstable">
        
        </tbody>
        </table>
    </div>
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
        assessments();
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

    //function to assessments
        function assessments(){
            var sid = "{{ session()->get('schooldetails.id') }}"
            $.ajax({
                method: 'GET',
                url: `/fetchassesments/${sid}`,
                success: function(res){
                    //console.log(res)
                    if (res.assessments.length == 0) {
                        $('#assessmentstable').html('<h5 class="text-danger">There are no Assessments registered yet</h5>')
                    } else {
                        $('#assessmentstable').html('')
                        $.each(res.assessments, function(key,item){
                            $('#assessmentstable').append('<tr>\
                            <td><input value="'+item.id+'" type="checkbox" name="" id="assessmentcheckbox"></td>\
                            <td>'+item.Assessment+'</td>\
                            <td>'+item.Type+'</td>\
                            <td>'+item.Year+'</td>\
                            <td>'+item.Term+'</td>\
                        </tr>')
                        })
                    }
                }
            });
        }

        //Register Assessment Ajax Request
        $("#assessmentregisterform").submit(function(e){
            e.preventDefault();
            $('#assessmentsubmitbtn').val('PLEASE WAIT...');
            removeValidationClasses($('#assessmentregisterform'));

            var formData = new FormData($('#assessmentregisterform')[0]);

            $.ajax({
                method: 'POST',
                url: '/registerassessment',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                //console.log(res);
                $('#assessmentsubmitbtn').val('SUBMIT ASSESSMENT');
                   if (res.status == 400) {
                    showError('assessmentname', res.messages.assessmentname);
                    showError('year', res.messages.year);
                    showError('term', res.messages.term);
                    showError('assessmenttype', res.messages.assessmenttype);
                   } else if(res.status == 200){
                    removeValidationClasses($('#assessmentregisterform'));
                    assessments();
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#assessmentregisterform')[0].reset();
                    //$('#examsubmitbtn').val('SUBMIT EXAM');
                    //$('#regresponse').text(res.messages)
                    $("#assessmentaddModal").modal('hide'); 
                   }   
               }
            });
        })

     //Edit exam ajax Request
     $("#assessmenteditform").submit(function(e){
            e.preventDefault();
            $('#assessmenteditbutton').val('PLEASE WAIT...');
            var formData = new FormData($('#assessmenteditform')[0]);

            $.ajax({
                method: 'POST',
                url: '{{ route('assessment.edit') }}',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                   //console.log(res)
                   $('#assessmenteditbutton').val('EDIT ASSESSMENT');
                   if (res.status == 400) {
                    showError('exameditname', res.messages.examname);
                    showError('edityear', res.messages.year);
                    showError('editterm', res.messages.term);
                    showError('examedittype', res.messages.examtype);
                   } else if(res.status == 200){
                    assessments();
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#assessmenteditform')[0].reset();
                   $("#assessmenteditModal").modal('hide'); 
                   }   
               }
            });
        })

    //Assessment deleting ajax
    $(document).on('click', '#examdeletebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#assessmentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select assessment(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this assessment? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deleteassessment/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    assessments();
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#response').text('Sorry!Something went wrong while deleting.Please try again later');  
                   }
                    }
                }) 
            }  
        }
     })

    //Handle Assessment editing
    $(document).on('click', '#exameditbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#assessmentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select an Assessment to edit');
        } else if(ids.length > 1){
            alert('You can only edit one Assessment at a time. Select only one Assessment');
        } else {
            fetchassessment2(ids)
           $('#assessmenteditModal').modal('show'); 
        }
     })

     //Handle Assessment Viewing
     $(document).on('click', '#examviewbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#assessmentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select an Assessment to view details');
        } else if(ids.length > 1){
            alert('You can only view one Assessment at a time');
        } else {
           fetchassessment3(ids)
           $('#assessmentviewModal').modal('show'); 
        }
     })
     
    //Handle Marks Addition 
    $(document).on('click', '#compresultsbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#assessmentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select an assessment for which results are to be Added');
        } else if(ids.length > 1){
            alert('You can only Add Marks of one class at a time.');
        } else {
           $('#examresid').val(ids)
           $('.resultscomputation').removeClass('d-none'); 
           fecthclasses();
        }
     })

    //function to fetchclasses
    function fecthclasses(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            var etype = "CBC";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses2/${sid}/${etype}`,
                success: function(res){
                    //console.log(res)
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

    //Function to fetch exam for viewing
    function fetchassessment3(id){
        $.ajax({
                method: 'GET',
                url: `/getassessment/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.cbcassessment;
                    $('#examtitle').text(data.Assessment)
                    $('#viewexam').text(data.Name)
                    $('#viewexamtype').text(data.Type)
                    $('#viewexamyear').text(data.Year)
                    $('#viewexamterm').text(data.Term)                  
                }
            })
        }

    //function to fetch details of an assessment for update
    function fetchassessment2(id){
        $.ajax({
                method: 'GET',
                url: `/getassessment/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    //console.log(res);
                    var data = res.cbcassessment;
                    $('#assessmentid').val(data.id)
                    $('#edityear').val(data.Year);
                    $('#exameditname').val(data.Name);
                    $('#edittermval').text(data.Term);
                    $('#edittermval').val(data.Term);
                    $('#examedittypeval').val(data.Type);
                    $('#examedittypeval').text(data.Type); 
                }
            })
        }

    //Handle hiding
    $(document).on('click', '#hideresultscompbtn',function(e){
         e.preventDefault();
         $('.resultscomputation').addClass('d-none');
     })

    //Navigate to compute exam results
    $("#computeresults").submit(function(e){
            e.preventDefault();
            var classid = $('#classtocompre').val()
            var examid = $('#examresid').val();
            var sid = "{{ session()->get('schooldetails.id') }}" 
            window.location = `/addcbcmarks/${examid}/${classid}/${sid}`;
        })

    });
</script>
@endsection