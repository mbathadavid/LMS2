@extends('layouts.layout')

@section('title','Classes')

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
<h4>Class(es)</h4>
<!----Class edit Modal start--->
<div id="classeditModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">CLASS EDITING</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="classeditform">
            <input hidden type="number" name="editclassid" id="editclassid">
            <div class="form-group mb-3">
            <label for=""><h6>School System</h6></label>
            <select name="editschoolsystem" id="editschoolsystem" class="form-control">
                <option id="css"></option>
                <option id="othercs"></option>
            </select>
            <div class="invalid-feedback"></div>
        </div>

                <div class="form-group mb-3">
                <label for=""><h6>Class<sup class="text-danger"><b></b></sup></h6></label>
                <select name="editclass" id="editclass" class="form-control">
                    
                </select>
                <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mb-3">
                    <label for=""><h6>Stream</h6></label>
                <input class="form-control" type="text" name="editstream" id="editstream" placeholder="Enter the stream eg. EAST or A">
                <div class="invalid-feedback"></div>
            </div>

                <div class="form-group mb-3">
                    <label for=""><h6>Number of Students</h6></label>
                <input class="form-control" type="number" name="editnostudents" id="editnostudents" placeholder="Enter the number of students">
                <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mb-3">
                <label for=""><h6>Class Teacher<sup class="text-danger"><b>*</b></sup></h6></label>
                <select name="editteacher" id="editteacher" class="form-control">
                <option id="editteacherval"></option>  
                </select>
                <div class="invalid-feedback"></div>
            </div>

                <div class="form-group mb-3 d-grid">
                    <input type="submit" class="btn btn-info" id="submiteditclass" value="EDIT CLASS">
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!----Class edit Modal start--->

<!----Set Current Term Modal start--->
<div id="currentTermmodal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">SET CURRENT TERM.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="settermform">
            <input hidden type="number" value="{{session()->get('schooldetails.id')}}" name="sid" id="sid">
            <input hidden type="text" name="settermclassid" id="settermclassid">
                <div class="form-group mb-3">
                <label for=""><h4>Select Term<sup class="text-danger"><b></b></sup></h4></label>
                <select name="currentterm" id="currentterm" class="form-control">
                    <option value="">Select The Current Term</option>
                    <option value="TERM ONE">TERM ONE</option>
                    <option value="TERM TWO">TERM TWO</option>
                    <option value="TERM THREE">TERM THREE</option>
                </select>
                <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mb-3 d-grid">
                    <input type="submit" class="btn btn-warning" id="submitcurrentterm" value="SET CURRENT TERM">
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!----Set Current Term Modal start--->


<div class="row border border-3 border-info mt-2 p-3">
    <div class="col-lg-3 col-md-3 border border-success p-3">
        <!-- <button class="btn btn-sm btn-info" type="button">EXPORT TO EXCEL</button>
        <button class="btn btn-sm btn-primary" type="button">IMPORT FROM EXCEL</button> -->
        <h6 class="border-bottom border-success text-center border-2">Register A New Class Here</h6>
        <form action="#" method="POST" id="registerclass">
            <h6 id="classregres" class="text-success p-2 bg-info d-none"></h6>
            <input type="number" value="{{session()->get('schooldetails.id')}}" name="sid" id="sid" hidden>
        <div class="form-group mb-3">
            <label for=""><h4>School System</h4></label>
            <select name="schoolsystem" id="schoolsystem" class="form-control">
                <option value="">Please Select The School System</option>
                <option value="8-4-4">8-4-4 System</option>
                <option value="CBC">CBC</option>
            </select>
            <div class="invalid-feedback"></div>
        </div>
            
        @if( session()->get('schooldetails.level') === "SecondarySchool")    
        <div id="secondary844" class="form-group mb-3">
        
        
        </div>

        @else( session()->get('schooldetails.level') === "PrimarySchool") 
        <div id="primary844" class="form-group mb-3">
        
        </div>

        @endif


        <div class="form-group mb-3">
            <label for=""><h4>Stream(if any)</h4></label>
        <input class="form-control" type="text" name="stream" id="stream" placeholder="Enter the stream eg. EAST or A">
        <div class="invalid-feedback"></div>
    </div>

        <div class="form-group mb-3">
            <label for=""><h4>Number of Students</h4></label>
        <input class="form-control" type="number" name="nostudents" id="nostudents" placeholder="Enter the number of students">
        <div class="invalid-feedback"></div>
        </div>

        <div class="form-group mb-3">
        <label for=""><h4>Class Teacher<sup class="text-danger"><b>*</b></sup></h4></label>
        <select name="teacher" id="teachers" class="form-control">
          <option value="">--Select Class Teacher--</option>  
        </select>
        <div class="invalid-feedback"></div>
    </div>

        <div class="form-group mb-3 d-grid">
            <input type="submit" class="btn btn-info" id="submitclass" value="ADD CLASS">
        </div>
        </form>
    </div>

    <div class="col-lg-9 col-md-9 border border-dark p-3">
        <div id="actionbtns" class="mb-2">
            <a href="/students" class="btn-sm btn-warning text-decoration-none" type="button"><i class="fas fa-users"></i>&nbsp;View Students</a>
            <button id="classdeletebtn" class="btn-sm btn-danger float-end" type="button"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button>
            <button id="classcurrenttermbtn" class="btn-sm btn-info float-end" type="button"><i class="fas fa-edit"></i>&nbsp;Set Current Term</button>
            <button id="classeditbtn" class="btn-sm btn-info float-end" type="button"><i class="fas fa-edit"></i>&nbsp;Edit</button>
            <button id="compresultsbtn" class="btn-sm btn-primary" type="button">Add Marks</button>
        </div>

        <div class="row d-none resultscomputation">
            <form action="#" id="computeresults">
                <input type="number" name="examresid" id="examresid" hidden>
                <div class="form-group mb-1">
                    <label for="">Select Exam For Results Computation</label>
                    <select name="class" id="classtocompre" class="form-control">
                     <option value="">--Select Exam--</option>
                    </select>
                </div>
                <div class="form-group mb-1 d-grid">
                    <input value="PROCEED TO COMPUTE RESULTS" type="submit" class="btn btn-sm btn-primary"> 
                </div>
                <button id="hideresultscompbtn" class="btn btn-sm btn-danger float-end">CANCEL</button>
            </form>
            <hr>
        </div>


        <h6 class="border-bottom border-danger text-center border-2">Registered Classes</h6>
        <div class="table-responsive">
            <div id="response"></div>
        <table id="classestable" class="table">
            <thead>
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Class</th>
                <th scope="col">School System</th>
                <th scope="col">Current Term</th>
                <th scope="col">Students</th>
                <th scope="col">Class teacher</th>
            </tr>
        </thead>
        <tbody>
            
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
        $('#classregres').addClass('d-none')
        fecthclasses()
        fetchteachers() 

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

        $("#registerclass").submit(function(e){
            e.preventDefault();
            removeValidationClasses($(this))
            $('#classregres').addClass('d-none')
            $("#submitclass").val('PLEASE WAIT...');
            $.ajax({
                url: '{{ route('class.register') }}',
               method: 'post',
               data: $(this).serialize(),
               dataType: 'json',
               success: function(res){
                if (res.status == 400) {
                    $("#submitclass").val('ADD CLASS');
                    showError('class', res.messages.class);
                    showError('schoolsystem', res.messages.schoolsystem);
                } else {
                    fecthclasses()
                    $('#registerclass')[0].reset();
                    $("#submitclass").val('ADD CLASS');
                    $('#classregres').removeClass('d-none')
                    $('#classregres').text(res.messages)
                }
               }
            })
        })
        //Manage Class
        $('#schoolsystem').change(function(e){
            e.preventDefault();
            var ssytem = $('#schoolsystem').val();
            var slevel = "{{ session()->get('schooldetails.level') }}"

            if (ssytem === "8-4-4" && slevel === "SecondarySchool") {
                var html = '<label for=""><h4>Class<sup class="text-danger"><b>*</b></sup></h4></label><select name="class" id="class" class="form-control"><option value="">--select Class--</option><option value="FORM ONE">FORM ONE</option><option value="FORM TWO">FORM TWO</option><option value="FORM THREE">FORM THREE</option><option value="FORM FOUR">FORM FOUR</option></select><div class="invalid-feedback"></div>';
                $("#secondary844").html(html);
            } else if(ssytem === "CBC" && slevel === "PrimarySchool") {
                var html = '<label for=""><h4>Grade Level<sup class="text-danger"><b>*</b></sup></h4></label>\
        <select name="class" id="class" class="form-control">\
            <option value="">--Select Grade--</option>\
            <option value="PP 1">PP 1</option>\
            <option value="PP 2">PP 2</option>\
            <option value="Grade ONE">Grade 1</option>\
            <option value="Grade TWO">Grade 2</option>\
            <option value="Grade THREE">Grade 3</option>\
            <option value="Grade FOUR">Grade 4</option>\
            <option value="Grade FIVE">Grade 5</option>\
            <option value="Grade SIX">Grade 6</option>\
            <option value="GRADE SEVEN">GRADE 7</option>\
            <option value="GRADE EIGHT">GRADE 8</option>\
            <option value="GRADE NINE">GRADE 9</option>\
        </select>\
        <div class="invalid-feedback"></div>';
                $("#primary844").html(html);
            } else if(ssytem === "8-4-4" && slevel === "PrimarySchool") {
                var html = '<label for=""><h4>Class<sup class="text-danger"><b>*</b></sup></h4></label><select name="class" id="class" class="form-control"><option value="">--select Class--</option><option value="Standard ONE">Standard ONE</option><option value="Standard TWO">Standard TWO</option><option value="Standard THREE">Standard THREE</option><option value="Standard FOUR">Standard FOUR</option><option value="Standard FIVE">Standard FIVE</option><option value="Standard SIX">Standard SIX</option><option value="Standard SEVEN">Standard SEVEN</option><option value="Standard EIGHT">Standard EIGHT</option></select><div class="invalid-feedback"></div>';
                $("#primary844").html(html);
            } else if(ssytem === "CBC" && slevel === "SecondarySchool") {
                var html = '<label for=""><h4>Grade Level<sup class="text-danger"><b>*</b></sup></h4></label><select name="class" id="class" class="form-control"><option value="">--select Grade--</option><option value="GRADE SEVEN">GRADE 7</option><option value="GRADE EIGHT">GRADE 8</option><option value="GRADE NINE">GRADE 9</option><option value="GRADE TEN">GRADE 10</option><option value="GRADE ELEVEN">GRADE 11</option><option value="GRADE TWELVE">GRADE 12</option></select><div class="invalid-feedback"></div>';
                $("#secondary844").html(html);
            }
        })
        //School System  for editing change
        $('#editschoolsystem').change(function(e){
            e.preventDefault();
            var ssytem = $('#editschoolsystem').val();
            var slevel = "{{ session()->get('schooldetails.level') }}";

            if (ssytem === "8-4-4" && slevel === "SecondarySchool") {
                var html = '<option value="">--select Class--</option><option value="FORM ONE">FORM ONE</option><option value="FORM TWO">FORM TWO</option><option value="FORM THREE">FORM THREE</option><option value="FORM FOUR">FORM FOUR</option>';
                $("#editclass").html(html);
            } else if(ssytem === "CBC" && slevel === "PrimarySchool") {
                var html = '<option value="">--Select Grade--</option>\
            <option value="PP 1">PP 1</option>\
            <option value="PP 2">PP 2</option>\
            <option value="Grade ONE">Grade 1</option>\
            <option value="Grade TWO">Grade 2</option>\
            <option value="Grade THREE">Grade 3</option>\
            <option value="Grade FOUR">Grade 4</option>\
            <option value="Grade FIVE">Grade 5</option>\
            <option value="Grade SIX">Grade 6</option>';
                $("#editclass").html(html);
            } else if(ssytem === "CBC" && slevel === "SecondarySchool") {
                var html = '<option value="">--select Grade--</option><option value="GRADE SEVEN">GRADE 7</option><option value="GRADE EIGHT">GRADE 8</option><option value="GRADE NINE">GRADE 9</option><option value="GRADE TEN">GRADE 10</option><option value="GRADE ELEVEN">GRADE 11</option><option value="GRADE TWELVE">GRADE 12</option>';
                $("#editclass").html(html);  
            } else if(ssytem === "8-4-4" && slevel === "PrimarySchool") {
                var html = '<option value="">--select Class--</option><option value="Standard ONE">Standard ONE</option><option value="Standard TWO">Standard TWO</option><option value="Standard THREE">Standard THREE</option><option value="Standard FOUR">Standard FOUR</option><option value="Standard FIVE">Standard FIVE</option><option value="Standard SIX">Standard SIX</option><option value="Standard SEVEN">Standard SEVEN</option><option value="Standard EIGHT">Standard EIGHT</option>';
                $("#editclass").html(html);  
            }
        })

        //Edit class ajax
        $("#classeditform").submit(function(e){
            e.preventDefault();
            $('#submiteditclass').val('PLEASE WAIT...');
            var formData = new FormData($('#classeditform')[0]);
            $.ajax({
                method: 'POST',
                url: '{{ route('class.edit') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   //console.log(res)
                   if (res.status == 400) {
                    $('#submiteditclass').val('EDIT CLASS');
                    showError('editclass', res.messages.editclass);
                    showError('editstream', res.messages.editstream);
                    showError('editnostudents', res.messages.editnostudents);
                    showError('editteacher', res.messages.editteacher);
                   } else if(res.status == 200){
                    fecthclasses()
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#classeditform')[0].reset();
                    $('#submiteditclass').val('EDIT CLASS');
                    $('#regresponse').text(res.messages)
                    $("#classeditModal").modal('hide');
                    $('#editteacher').html(''); 
                   }   
               }
            });
        })
        
        //Set Current Term Form Submission
        $("#settermform").submit(function(e){
            e.preventDefault();
            $('#submitcurrentterm').val('PLEASE WAIT...');
            var formData = new FormData($('#settermform')[0]);
            $.ajax({
                method: 'POST',
                url: '{{ route('class.currentterm') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   $('#submitcurrentterm').val('SET CURRENT TERM');
                   if (res.status == 400) {
                    showError('currentterm', res.messages.currentterm);
                   } else if(res.status == 200){
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#settermform')[0].reset();
                    $("#currentTermmodal").modal('hide');
                    fecthclasses() 
                   }   
               }
            });
        })


        //function to fetchclasses
        function fecthclasses(){
            var sid = {{ session()->get('schooldetails.id') }}
            $.ajax({
                method: 'GET',
                url: `/fetchclasses/${sid}`,
                success: function(res){
                    //console.log(res)
                    if (res.classes.length == 0) {
                        $('tbody').html('<h5 class="text-danger">There are no classes registered yet</h5>')
                    } else {
                        $('tbody').html('')
                        $.each(res.classes, function(key,item){
                            $('tbody').append('<tr>\
                            <td><input value="'+item.id+'" type="checkbox" name="" id="classselectbox"></td>\
                            <td>'+item.class+' '+(item.stream == null ? "" : item.stream)+'</td>\
                            <td>'+item.educationsystem+'</td>\
                            <td>'+item.current_term+'</td>\
                            <td>'+item.snumber+'</td>\
                            <td>'+item.classteacher+'</td>\
                        </tr>');
                        })

                        $("#classestable").DataTable().fnDestroy()

                        $('#classestable').DataTable({
                        ordering: false,
                        paging: false,
                        searching: true
                         });
                    }
                }
            });
        }
        //function to fetch Teacher
        function fetchteachers() {
            var sid = {{ session()->get('schooldetails.id') }}
            var utype = "Support Staff";
            $.ajax({
                method: 'GET',
                url: `/classteacher/${sid}/${utype}`,
                //dataType: 'jsons',
                success: function(res) {
                    //console.log(res.teachers);
                    if (res.teachers == 0) {
                        $("#teachers").html('')
                        $('#teachers').html('No Teachers registered yet')
                    } else {
                        $("#teachers").html('')
                        $.each(res.teachers, function(key,item){
                            $('#teachers').append('<option value="'+item.Salutation+' '+item.Fname+' '+item.Lname+'">'+item.Salutation+' '+item.Fname+' '+item.Lname+'</option>')
                        })
                    }
                }

            })
        }
        //fetchteachers2
        function fetchteachers2() {
            var sid = {{ session()->get('schooldetails.id') }}
            var utype = "Support Staff";
            $.ajax({
                method: 'GET',
                url: `/classteacher/${sid}/${utype}`,
                //dataType: 'jsons',
                success: function(res) {
                        $('#editteacher').html('');
                        $.each(res.teachers, function(key,item){
                            $('#editteacher').append('<option value="'+item.Salutation+' '+item.Fname+' '+item.Lname+'">'+item.Salutation+' '+item.Fname+' '+item.Lname+'</option>')
                        })
                }

            })
        }

        $(document).on('change', '#classselectbox', function(e){
            e.preventDefault();
            $("#actionbtns").removeClass('d-none')
        })
            //function to fetchexams
            function exams(){
            $.ajax({
                method: 'GET',
                url: '/fetchexams',
                success: function(res){
                    //console.log(res)
                    if (res.exams.length == 0) {
                        $('#classtocompre').text('Sorry!There are no classes added recently')
                    } else {
                        $('#classtocompre').html('');
                        $.each(res.exams, function(key,item){
                            $('#classtocompre').append('<option value="'+item.id+'">'+item.Examination+'</option>')
                        })
                    }
                }
            });
        }
//Navigate to compute exam results
    $("#computeresults").submit(function(e){
            e.preventDefault();
            //var classid = $('#classtocompre').val()
            var classid = $('#examresid').val()
            var examid = $('#classtocompre').val();
            window.location = `/classresults/${examid}/${classid}`;
        })

//function to fetch details of a class for update
    function fetchclass(id){
        $.ajax({
                method: 'GET',
                url: `/getclass/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.class;
                    var slevel = "{{ session()->get('schooldetails.level') }}";
                    $("#editclassid").val(data.id)
                    $('#css').val(data.educationsystem)
                    $('#css').text(data.educationsystem)

                    if (data.educationsystem === "8-4-4" && slevel === "SecondarySchool") {
                        $('#othercs').val('CBC');
                        $('#othercs').text('CBC');
                        var html = '<option id="classeditval"></option><option value="FORM ONE">FORM ONE</option><option value="FORM TWO">FORM TWO</option><option value="FORM THREE">FORM THREE</option><option value="FORM FOUR">FORM FOUR</option>';
                        $('#editclass').html(html)
                    } else if(data.educationsystem === "CBC" && slevel === "PrimarySchool") {
                        $('#othercs').val('8-4-4');
                        $('#othercs').text('8-4-4 System');
                        var html = '<option id="classeditval"></option>\
                        <option value="PP 1">PP 1</option>\
                        <option value="PP 2">PP 2</option>\
                        <option value="Grade ONE">Grade 1</option>\
                        <option value="Grade TWO">Grade 2</option>\
                        <option value="Grade THREE">Grade 3</option>\
                        <option value="Grade FOUR">Grade 4</option>\
                        <option value="Grade FIVE">Grade 5</option>\
                        <option value="Grade SIX">Grade 6</option>';

                        $('#editclass').html(html)
                    } else if(data.educationsystem === "CBC" && slevel === "SecondarySchool") {
                        $('#othercs').val('8-4-4');
                        $('#othercs').text('8-4-4 System');
                        var html = '<option id="classeditval"></option><option value="GRADE SEVEN">GRADE 7</option><option value="GRADE EIGHT">GRADE 8</option><option value="GRADE NINE">GRADE 9</option><option value="GRADE TEN">GRADE 10</option><option value="GRADE ELEVEN">GRADE 11</option><option value="GRADE TWELVE">GRADE 12</option>';
                        $("#editclass").html(html); 
                    } else if(data.educationsystem === "8-4-4" && slevel === "PrimarySchool") {
                        $('#othercs').val('CBC');
                        $('#othercs').text('CBC');
                        var html = '<option id="classeditval"></option><option value="Standard ONE">Standard ONE</option><option value="Standard TWO">Standard TWO</option><option value="Standard THREE">Standard THREE</option><option value="Standard FOUR">Standard FOUR</option><option value="Standard FIVE">Standard FIVE</option><option value="Standard SIX">Standard SIX</option><option value="Standard SEVEN">Standard SEVEN</option><option value="Standard EIGHT">Standard EIGHT</option>';
                        $("#editclass").html(html);
                    }

                    $('#classeditval').val(data.class)
                    $('#classeditval').text(data.class)
                    $('#editteacherval').val(data.classteacher)
                    $('#editteacherval').text(data.classteacher)
                    $('#editstream').val(data.stream)
                    $('#editnostudents').val(data.snumber)
                }
            })
        }

    //Handle class editing
    $(document).on('click', '#classeditbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#classselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a class to edit');
        } else if(ids.length > 1){
            alert('You can only edit one class at a time. Select only one class');
        } else {
            fetchclass(ids)
            fetchteachers2()
           $('#classeditModal').modal('show'); 
        }
     })

     //Handle Current Term Setting
     $(document).on('click', '#classcurrenttermbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#classselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a class to Set The Current Term');
        // } else if(ids.length > 1){
        //     alert('You can only edit one class at a time. Select only one class');
        } else {
            // fetchclass(ids)
            // fetchteachers2()
            $('#settermclassid').val(ids)
            //console.log(typeof(JSON.stringify(ids)));
           $('#currentTermmodal').modal('show'); 
        }
     })

     //Navigate to results management page
     $(document).on('click', '#compresultsbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#classselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a class for which results is to be computed');
        } else if(ids.length > 1){
            alert('You can only compute results of one class at a time.');
        } else {
           $('#examresid').val(ids)
           $('.resultscomputation').removeClass('d-none'); 
           exams()
        }
     })

      //Handle hiding
      $(document).on('click', '#hideresultscompbtn',function(e){
         e.preventDefault();
         $('.resultscomputation').addClass('d-none');
     })

    //Class deleting ajax
     $(document).on('click', '#classdeletebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#classselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select class(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this class? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deleteclass/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fecthclasses()
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#response').text('Sorry!Something went wrong while deleting.Please try again later');  
                   }
                    }
                }) 
            }  
        }
     })
    });
</script>
@endsection