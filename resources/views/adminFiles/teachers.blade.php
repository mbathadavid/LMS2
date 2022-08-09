@extends('layouts.layout')

@section('title','Teachers')

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
<h4>Teacher(s)</h4>
<div class="mb-2">
<button class="btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#teacheraddModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD TEACHER</button>
<a href="/downloadteachers" type="button" class="btn-sm btn-info"><i class="fas fa-file-csv"></i>&nbsp;EXPORT TO EXCEL</a>
<a href="/teachersexcelimport" type="button" class="btn-sm btn-primary" type="button"><i class="fas fa-file-csv"></i>&nbsp;IMPORT FROM EXCEL</a>
<div id="regresponse"></div>
</div>
<!---Teacher edit modal start--->
<div class="modal w3-animate-zoom" id="teachereditModal" tabindex="-1" aria-labelledby="teachereditModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Support Staff Edit Modal<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="teachereditform" class="p-2" method="POST" enctype="multipart/form-data">
         <div class="row">
            <div class="col-lg-6">
            <input type="number" name="editid" id="editid" hidden>
            <input type="text" name="editrole" id="editrole" hidden>
            <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" hidden>
             <div class="form-group mb-2">
                <label for="">Salutation</label>
                <select name="editsalutation" id="editsalutation" class="form-control">
                    <option id="editsalval"></option>
                    <option value="Ms">Miss</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Madam">Madam</option>
                </select>
                <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
                <label for="">First Name</label>
                <input class="form-control" type="text" name="editfname" id="editfname">
                <div class="invalid-feedback"></div>
             </div>
             <!-- <div class="form-group mb-2">
                <label for="">Second Name</label>
                <input class="form-control" type="text" name="editsname" id="editsname">
                <div class="invalid-feedback"></div>
             </div> -->
             <div class="form-group mb-2">
                <label for="">Last Name</label>
                <input class="form-control" type="text" name="editlname" id="editlname">
                <div class="invalid-feedback"></div>
             </div>
            </div>
            <div class="col-lg-6">
            <div class="form-group mb-2">
                <label for="">Phone Number</label>
                <input class="form-control" type="text" name="editpno" id="editpno">
                <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
                <label for="">Email</label>
                <input class="form-control" type="text" name="editemail" id="editemail">
                <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
                <label for="">Position</label>
                <select class="form-control" name="editposition" id="editposition">
                    <option id="editpositionval"></option>
                    <option value="Principal">Principal</option>
                    <option value="Deputy Principal">Deputy Principal</option>
                    <option value="Senior Teacher">Senoir Teacher</option>
                    <option value="Games Captain">Games Captain</option>
                    <option value="HOD">Head of Department</option>
                    <option value="Club Patron">Club Patron</option>
                    <option value="Teacher">Teacher</option>
                </select>
                <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
                <label for="">Gender</label>
                <div id="editgenderdiv">

                </div>
             </div>
             <div class="form-group mb-2">
              <label for="">Profile Photo</label>
              <input onchange="preview2()" class="form-control" type="file" name="editprofile" id="editprofile">
              <div class="invalid-feedback"></div>
             </div>
            </div>
            <div class="text-center mb-2" id="teachereditprofile">

            </div>
            <div class="form-group mb-2 d-grid">
             <input type="submit" id="editteachersubmitbtn" class="btn btn-warning btn-sm rounded-0" value="EDIT TEACHER">
            </div>
         </div>
        </form>
        </div>
    </div>
    </div>
</div>
<!---Teacher edit modal start--->

<!---Teacher assign priviledges modal start--->
<div class="modal w3-animate-zoom" id="teacherassignprivildegesModal" tabindex="-1" aria-labelledby="teacherassignprivildegesModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Assign Priviledges Modal<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="teacherassignpriviledges" class="p-2" method="POST" enctype="multipart/form-data">
         <div class="row">
            <div class="col-lg-6 align-items-center justify-content-center">
            <input type="number" name="editid" id="editid" hidden>
            <input type="number" name="staffid" id="staffid" hidden>
            <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" hidden>
            <h5>Assign Priviledges For:</h5>
             <h6 id="staffheading" class="text-danger"></h6>
            </div>

            <div class="col-lg-6">
                <h6>Please Tick Where Appropriate</h6>
                <input type="checkbox" value="Collect Fees" name="priviledge" id="priviledge">&nbsp; Collect Fees <br>
                <input type="checkbox" value="Manage Expenses" name="priviledge" id="priviledge">&nbsp; Manage Expenses <br>
                <input type="checkbox" value="Fee Structure Manipulation" name="priviledge" id="priviledge">&nbsp; Manipulate Fee Structure<br>
                <input type="checkbox" value="Manage Teachers" name="priviledge" id="priviledge">&nbsp; Manage Teachers <br>
                <input type="checkbox" value="Manage Students" name="priviledge" id="priviledge">&nbsp; Manage Students <br>
                <input type="checkbox" value="Manage Parents" name="priviledge" id="priviledge">&nbsp; Manage Parents <br>
                <input type="checkbox" value="Manage Support Staff" name="priviledge" id="priviledge">&nbsp; Manage Support Staff  <br>
                <input type="checkbox" value="Manage Library" name="priviledge" id="priviledge">&nbsp; Manage Library<br>
                <input type="checkbox" value="Manage Classes" name="priviledge" id="priviledge">&nbsp; Manage Classes<br>
                <input type="checkbox" value="Manage Subjects" name="priviledge" id="priviledge">&nbsp; Manage  Subjects<br>
                <input type="checkbox" value="Manipulate Grading System" name="priviledge" id="priviledge">&nbsp; Manipulate Grading System <br>
                <input type="checkbox" value="Create Result Thread" name="priviledge" id="priviledge">&nbsp; Create Result Thread  <br>
                <input type="checkbox" value="Compute Final Results For Class" name="priviledge" id="priviledge">&nbsp; Compute Final Result For Class  <br>
                <input type="checkbox" value="Manage Communications" name="priviledge" id="priviledge">&nbsp; Manage Communications<br>
            
                <h6 class="text-danger m-2 d-none" id="priviledgealert"></h6>
            </div>
            <div class="form-group mb-2 d-grid">
             <input type="submit" id="editteachersubmitbtn" class="btn btn-warning btn-sm rounded-0" value="ASSIGN PRIVILEDGES">
            </div> 
        </form>
    </div>
    </div>
    </div>
    </div>
</div>
<!---Teacher assign priviledges modal start--->

<!---Teacher view modal start--->
<div class="modal w3-animate-zoom" id="teacherviewModal" tabindex="-1" aria-labelledby="teacherviewModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel"><span id="titleteacher" class="text-danger"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="row">
         <div class="text-center" id="teacherimg"></div>
            <div id="teacherdetails" class="text-center">
                
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<!---Teacher view modal start--->

<!---Teacher add modal start--->
<div class="modal fade" id="teacheraddModal" tabindex="-1" aria-labelledby="teacheraddModalLabel">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Register Teacher</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="teacherregform" class="p-2" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6">
                <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" hidden>
                <input hidden type="text" name="role" value="Teacher" id="role">
                    <div class="form-group mb-3">
                        <label for="">Salutation<sup><b class="text-danger">*</b></sup></label>
                        <select name="salutation" id="salutation" class="form-control">
                            <option value="">--select salutation--</option>
                            <option value="Ms">Miss</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Teacher">Madam</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">FirstName</label>
                        <input placeholder="First Name" type="text" name="firstname" id="firstname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">SecondName</label>
                        <input placeholder="Second Name" type="text" name="secondname" id="secondname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">LastName</label>
                        <input placeholder="Last Name" type="text" name="lastname" id="lastname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group mb-3">
                        <label for="">Phone Number</label>
                        <input placeholder="Phone Number" type="tel" name="phone" id="phone" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input placeholder="Email address" type="email" name="email" id="email" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Position<sup><b class="text-danger">*</b></sup></label>
                        <select name="position" id="position" class="form-control">
                            <option value="">--select position--</option>
                            @if( session()->get('schooldetails.level') === "SecondarySchool") 
                            <option value="Principal">Principal</option>
                            <option value="Deputy Principal">Deputy Principal</option>
                            @else( session()->get('schooldetails.level') === "PrimarySchool") 
                            <option value="Head Teacher">Head Teacher</option>
                            <option value="Deputy Head Teacher">Deputy Head Teacher</option>
                            @endif
                            <option value="Senior Teacher">Senior Teacher</option>
                            <option value="Games Captain">Games Captain</option>
                            <option value="HOD">Head of Department</option>
                            <option value="Club Patron">Club Patron</option>
                            <option value="Teacher">Teacher</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Gender</label><br>
                        <input type="radio" name="gender" id="gender" value="Male">&nbsp;Male
                        <input type="radio" name="gender" id="gender1" value="Female">&nbsp;Female
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Profile Photo</label><br>
                        <input onchange="preview()" type="file" name="file" id="file" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                    <div class="text-center mb-3">
                    <img width="150" id="frame" height="150" class="img-fluid" src="{{ asset('images/avatar.png') }}" alt="">
                    </div>

                <div class="form-group mb-3 d-grid">
                    <button type="submit" id="teacheregbtn" class="btn btn-info">REGISTER TEACHER</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    </div>
</div>

<div class="row border border-3 border-info p-3">
    
<div class="table-responsive">
<div id="actionbtns" class="d-none">
<!---
<button class="btn btn-sm btn-info float-end"><i class="fas fa-envelope"></i>&nbsp;Send Email</button>
<button class="btn btn-sm btn-success float-end"><i class="fas fa-sms"></i>&nbsp;Send SMS</button>
--->
<button id="deactivatebtn" class="btn btn-sm btn-primary float-end m-1">Deactivate</button>
<button id="activatebtn" class="btn btn-sm btn-success float-end m-1">Activate</button>
<button id="viewbtn" class="btn btn-sm btn-info float-end m-1"><i class="fas fa-eye"></i>&nbsp;View</button>
<button id="teachereditbtn" class="btn btn-sm btn-warning float-end m-1"><i class="fas fa-edit"></i>&nbsp;Edit</button>
<button id="priviledgesbtn" class="btn btn-sm btn-warning float-end m-1"><i class="fas fa-edit"></i>&nbsp;Assign Priviledges</button> 
<button id="teacherdelbtn" class="btn btn-sm btn-danger float-end m-1"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button> 
</div> 
<table class="table" id="teacherstable">
            <thead>
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Account Active?</th>
                <th scope="col">Gender</th>
                <th scope="col">Position</th>
                <th scope="col">Priviledges</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>  
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
@endsection 
@endif


@section('script')
<script>
function preview(){
frame.src=URL.createObjectURL(event.target.files[0]);
}

function preview2(){
frame2.src=URL.createObjectURL(event.target.files[0]);
}
</script>
<script>
    $(document).ready(function(){
        fetchteachers();
        //set csrf
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        function fetchteachers() {
            var sid = "{{ session()->get('schooldetails.id') }}";
            var uid = "{{ session()->get('LoggedInUser.id') }}";
            var stype = "Teacher";
            $.ajax({
                method: 'GET',
                url: `/fetchteachers/${sid}/${uid}/${stype}`,
                //dataType: 'jsons',
                success: function(res) {
                    if (res.teachers.length == 0) {
                        $('tbody').html('<h5 class="text-center text-danger">No any teachers registered as at now</h5>');
                    } else {
                        $('tbody').html('');
                         $.each(res.teachers, function(key,item){
                        $('tbody').append('<tr>\
                        <td><input value="'+item.id+'" type="checkbox" class="checkboxid" name="teachercheckboxid" id="teachercheckboxid"></td>\
                        <td><img  width="50" height="50" class="img-fluid" src="images/'+item.Profile+'" alt=""></td>\
                        <td>'+item.Salutation+' '+item.Fname+' '+item.Lname+'</td>\
                        <td><button class="btn btn-success btn-sm">'+item.Active+'</button></td>\
                        <td>'+item.Gender+'</td>\
                        <td>'+item.Position+'</td>\
                        <td>'+item.priviledges+'</td>\
                        <td>'+item.Email+'</td>\
                        <td>'+item.Phone+'</td>\
                    </tr>');
                    }); 
                    
                        $("#teacherstable").DataTable().fnDestroy()

                        $('#teacherstable').DataTable({
                        ordering: false,
                        paging: false,
                        searching: true
                         });

                    }
                   
                }

            })
        }

        $(document).on('change', '.checkboxid',function(e){
            e.preventDefault();
            var id = $(this).val();
            $('#actionbtns').removeClass('d-none');
        })

        $("#teacherregform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($("#teacherregform"))
            $('#regresponse').addClass('d-none');
            $('#teacheregbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#teacherregform')[0]);

            $.ajax({
                method: 'POST',
                url: '{{ route('teacher.register') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   if (res.status == 400) {
                    $('#teacheregbtn').val('REGISTER TEACHER');
                    showError('salutation', res.messages.salutation);
                    showError('firstname', res.messages.firstname);
                    showError('secondname', res.messages.secondname);
                    showError('lastname', res.messages.lastname);
                    showError('active', res.messages.active);
                    showError('phone', res.messages.phone);
                    showError('email', res.messages.email);
                    showError('position', res.messages.position);
                    showError('gender', res.messages.gender);
                    showError('file', res.messages.file);
                   } else if(res.status == 200){
                    removeValidationClasses($("#teacherregform"))
                    fetchteachers();
                    $('#teacherregform')[0].reset();
                    $('#teacheregbtn').val('REGISTER TEACHER');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#regresponse').removeClass('d-none');
                    $('#teacherregform').find('input').val('');
                   $('#frame').src = 'images/avatar.png';
                   $("#teacheraddModal").modal('hide'); 
                   }
                   
               }
            });
        })
    //Update Teacher ajax Request
    $("#teachereditform").submit(function(e){
            e.preventDefault();
            $('#regresponse').addClass('d-none');
            $('#editteachersubmitbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#teachereditform')[0]);

            $.ajax({
                method: 'POST',
                url: '{{ route('teacher.edit') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   if (res.status == 400) {
                    $('#editteachersubmitbtn').val('EDIT TEACHER');
                    showError('editsalutation', res.messages.editsalutation);
                    showError('editfname', res.messages.editfname);
                    showError('editlname', res.messages.editlname);
                    showError('editposition', res.messages.editposition);
                    showError('editgender', res.messages.editgender);
                    showError('editprofile', res.messages.editprofile);
                   } else if(res.status == 200){
                    fetchteachers();
                    $('#teachereditform')[0].reset();
                    $('#editteachersubmitbtn').val('EDIT TEACHER');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    $('#regresponse').removeClass('d-none');
                   $('#frame').src = 'images/avatar.png';
                   $("#teachereditModal").modal('hide'); 
                   }
                   
               }
            });
        })

    //priviledges Assignment Submission
    $("#teacherassignpriviledges").submit(function(e){
            e.preventDefault();
            $('#priviledgealert').addClass('d-none')
            $('#priviledgealert').text('')
            // $('#regresponse').addClass('d-none');
            // $('#editteachersubmitbtn').val('PLEASE WAIT...');
            var priviledges = [];
            var formData = new FormData($('#teacherassignpriviledges')[0]);

            $('#priviledge:checked').each(function(i){
                priviledges[i] = $(this).val()
            })

            formData.append('priviledges',priviledges);

            $.ajax({
                method: 'POST',
                url: '/assignpriviledges',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                  console.log(res);
                  if (res.status == 400) {
                   // $('#editteachersubmitbtn').val('EDIT TEACHER');
                    $('#priviledgealert').removeClass('d-none')
                    $('#priviledgealert').text(res.messages.priviledges)
                   } else if(res.status == 200){
                    $('#teacherassignpriviledges')[0].reset();
                    //$('#editteachersubmitbtn').val('EDIT TEACHER');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                   $("#teacherassignprivildegesModal").modal('hide'); 
                   }

                  fetchteachers()
               }
            });
        })

        
    //Function to fetch teacher for viewing
    function fetchteacher(id){
        //var sid = {{ session()->get('schooldetails.id') }}
        $.ajax({
                method: 'GET',
                url: `/getteacher/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.teacher;
                    $('#titleteacher').text(data.Salutation+' '+data.Fname+' '+data.Lname);
                    $('#teacherimg').html('');
                    $('#teacherimg').append('<img src="images/'+data.Profile+'" class="img-fluid"/>');
                    $('#teacherdetails').html('');
                    $('#teacherdetails').append('<h6>Gender : <span class="text-danger">'+data.Gender+'</span></h6>\
                    <h6>Position : <span class="text-danger">'+data.Position+'</span></h6>\
                    <h6>Email : <span class="text-danger">'+data.Email+'</span></h6>\
                    <h6>Phone : <span class="text-danger">'+data.Phone+'</span></h6>\
                    ');
                }                   
                })
        }
    //Function to fetch teacher for editing
    function fetchteacher2(id){
        $.ajax({
                method: 'GET',
                url: `/getteacher/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.teacher;
                    $('#teachereditprofile').html('<img width="150" id="frame2" height="150" class="img-fluid" src="images/'+data.Profile+'" alt="">');
                    $('#editid').val(data.id);
                    $('#editsalval').val(data.Salutation);
                    $('#editsalval').text(data.Salutation);
                    $('#editrole').val(data.Role);
                    $('#editfname').val(data.Fname);
                    $('#editsname').val(data.Sname);
                    $('#editlname').val(data.Lname);
                    $('#editpno').val(data.Phone);
                    $('#editemail').val(data.Email);
                    $('#editpositionval').val(data.Position);
                    $('#editpositionval').text(data.Position);

                    if (data.Gender == 'male') {
                        $('#editgenderdiv').html('');
                        $('#editgenderdiv').append('<input checked type="radio" name="editgender" id="editgender" value="male">&nbsp;Male\
                        <input type="radio" name="editgender" id="editgender" value="female">&nbsp;Female');
                    } else {
                        $('#editgenderdiv').html('');
                        $('#editgenderdiv').html('<input type="radio" name="editgender" id="editgender" value="male">&nbsp;Male\
                        <input checked type="radio" name="editgender" id="editgender" value="female">&nbsp;Female'); 
                    }
                }                   
                })
        }

    //Fetch Tachers for assigning privildeges
    function fetchteacher3(id){
        $.ajax({
                method: 'GET',
                url: `/getteacher/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.teacher;
                    $('#staffid').val(data.id);
                    $('#staffheading').text(`${data.Salutation} ${data.Fname} ${data.Lname}`);
                }                   
                })
        }   

    //Teacher Viewing
     $(document).on('click', '#viewbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#teachercheckboxid:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a Teacher to view details');
        } else if(ids.length > 1){
            alert('You can only view one Teacher at a Time.Select only one Teacher');
        } else {
            fetchteacher(ids)
           $('#teacherviewModal').modal('show'); 
        }
     })
    //Teacher edit modal
    $(document).on('click', '#teachereditbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#teachercheckboxid:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a Teacher to edit');
        } else if(ids.length > 1){
            alert('You can only edit one Teacehr at a time. Select only one Teacher');
        } else {
            fetchteacher2(ids)
           $('#teachereditModal').modal('show'); 
        }
     })

     //Teacher Priviledges Modal
     $(document).on('click', '#priviledgesbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#teachercheckboxid:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a Teacher to Assign Priviledges');
        } else if(ids.length > 1){
            alert('You can only assign privildeges to one teacher at a time. Select only one Teacher');
        } else {
            fetchteacher3(ids)
           $('#teacherassignprivildegesModal').modal('show'); 
        }
     })

         //Teacher deleting ajax
         $(document).on('click', '#teacherdelbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#teachercheckboxid:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Teacher(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this Teacher? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deleteteacher/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    fetchteachers();
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
        }
     })
     //Student deactivating account ajax
    $(document).on('click', '#deactivatebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#teachercheckboxid:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Teacher(s) whose account(s) is/are to be deactivated')
        } else {
            var confirm = window.confirm(`Are you sure you want to Deactivate this Teacher Account? Once you deactivate they will not be able to login`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deactivateteacher/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    fetchteachers();
                    $('#regresponse').removeClass('d-none');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
        }
     })
//Teacher account activating ajax request
$(document).on('click', '#activatebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#teachercheckboxid:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Teacher(s) whose account(s) is/are to be activated')
        } else {
            var confirm = window.confirm(`Are you sure you want to activate this Teacher Account? Once you activate they will not be able to login to the System`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/activateteacher/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    fetchteachers();
                    $('#regresponse').removeClass('d-none');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
        }
     })

    })
</script>
@endsection