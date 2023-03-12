@extends('layouts.layout')

@section('css')
@endsection

@section('title','Parents')

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
<h4>Parents(s)/Guardian(s)</h4>
<div class="mb-2">
<button class="btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#teacheraddModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD PARENT</button>
<div id="regresponse" class="text-center d-none mb-1"></div>
</div>
<!---parent view Modal--->
<div class="modal w3-animate-zoom" id="parentviewModal" tabindex="-1" aria-labelledby="parentviewModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel"><span id="titleparent" class="text-danger"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="row">
         <div class="text-center" id="parentimg2"></div>
            <div id="parentdetails" class="text-center">
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<!---parent view Modal--->

<!---parent Edit Modal--->
<div class="modal w3-animate-zoom" id="parentupdateModal" tabindex="-1" aria-labelledby="parentupdateModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center">Parent Update Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       <form action="#" method="POST" enctype="multipart/form-data" id="parenteditform">
           <div class="row">
               <div class="col-lg-6">
                   <input type="number" name="editid" id="editid" hidden>
                <div class="form-group mb-2">
                <label for="">First Name</label>
                 <input type="text" class="form-control" name="editfname" id="editfname">
                 <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Second Name</label>
                 <input type="text" class="form-control" name="editsname" id="editsname">
                 <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Last Name</label>
                 <input type="text" class="form-control" name="editlname" id="editlname">
                 <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Parent/Guardian?</label>
                <select class="form-control" name="editpargurd" id="editpargurd">
                <option id="editparval"></option>
                <option value="Parent">Parent</option>
                <option value="Guardian">Guardian</option>
                <div class="invalid-feedback"></div>
                </select>
                </div>
               </div>
               
               <div class="col-lg-6">
                <div class="form-group mb-2">
                <label for="">Phone Number</label>
                <input class="form-control" type="tel" name="editphone" id="editphone">
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Alternative Phone</label>
                <input class="form-control" type="tel" name="editaltphone" id="editaltphone">
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Email</label>
                <input class="form-control" type="email" name="editemail" id="editemail">
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                 <label for="">Gender</label>
                 <div id="genderdiv">

                 </div>
                 <div class="invalid-feedback"></div>
                </div>
                </div>
                
                <div class="d-flex justify-content-center p-2 mb-2">
               <div class="col-lg-10 border-2 border-success">
               <h6 class="text-center text-success">Match A Parent with their Child/Children</h6>
                        <div id="editunselectedstudents" class="text-danger d-none">You must match the parent with His/her child/children</div>
                        <div class="border border-success p-3" id="filtredstudents">
                        <div class="form-group mb-3" id="studentsfilter">
                            <label><h6 class="text-danger">Select Students</h6></label>
                            <select name="editstudentfilter" id="editstudentfilter" class="form-control">
                                <option value="">--Select Student(s)--</option>
                                <option value="ALL">ALL</option>
                            </select>
                        </div>
                            <div id="tablediv" class="table-responsive">
                            <table id="editstudentselecttable" class="table">
                             <thead>
                             <tr>
                                <th scope="col">Sel</th>
                                <th scope="col">UPI</th>
                                <th scope="col">Name</th> 
                            </tr>
                             </thead>
                             <tbody id="editparentsstudent">
            
                             </tbody>
                            </table>
                        </div>
                        </div>
                        </div>
                        </div> 
                    

                    <div class="form-group mb-3">
                        <label for="">Profile Photo</label><br>
                        <input onchange="preview2()" type="file" name="file" id="file" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="text-center mb-3">
                    <img width="150" id="frame2" height="150" class="img-fluid" src="{{ asset('images/avatar.png') }}" alt="">
                    </div>
                    
               <div class="form-group d-grid">
                <input type="submit" id="editsubmitbtn" value="EDIT PARENT/GUARDIAN" class="form-control rounded-0 btn btn-warning btn-sm">   
               </div>
           </div>
       </form>
        </div>
    </div>
    </div>
</div>
<!---parent Edit Modal--->

<div class="modal fade" id="teacheraddModal" tabindex="-1" aria-labelledby="teacheraddModalLabel">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Register Parent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="parentregform" class="p-2" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6">
                    <input hidden type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid">
                    <div class="form-group mb-3">
                        <label for="">First Name</label>
                        <input placeholder="First Name" type="text" name="firstname" id="firstname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Second Name</label>
                        <input placeholder="Second Name" type="text" name="secondname" id="secondname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Last Name</label>
                        <input placeholder="Last Name" type="text" name="lastname" id="lastname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Parent/Guardian?</label>
                        <select class="form-control" name="parent_guardian" id="parent_guardian">
                            <option value="">--Select/Guardian--</option>
                            <option value="Parent">Parent</option>
                            <option value="Guardian">Guardian</option>
                        </select>
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
                        <label for="">Alternative Number</label>
                        <input placeholder="Alternative Phone Number" type="tel" name="altphone" id="altphone" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input placeholder="Email address" type="email" name="email" id="email" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Gender</label><br>
                        <input type="radio" name="gender" id="gender" value="Male">&nbsp;Male
                        <input type="radio" name="gender" id="gender" value="Female">&nbsp;Female
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                <div id="studentsselectionmodel" style="background-color: white" class="bg-clear col-lg-10 mb-2 p-4">
                        <h6 class="text-center text-success">Match A Parent with their Child/Children</h6>
                        <div id="unselectedstudents" class="text-danger d-none">You must match the parent with His/her child/children</div>

                        <div class="border border-success p-3" id="filtredstudents">
                        <div class="form-group mb-3" id="studentsfilter">
                            <label><h6 class="text-danger">Select Students</h6></label>
                            <select name="studentfilter" id="studentfilter" class="form-control">
                                <option value="">--Select Student(s)--</option>
                                <option value="ALL">ALL</option>
                            </select>
                        </div>
                            <div class="table-responsive">
                            <table id="studentselecttable" class="table">
                             <thead>
                             <tr>
                                <th scope="col">Sel</th>
                                <th scope="col">UPI/Adm No</th>
                                <th scope="col">Name</th> 
                            </tr>
                             </thead>
                             <tbody id="parentsstudent">
            
                             </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Profile Photo</label><br>
                        <input onchange="preview()" type="file" name="file" id="file" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="text-center mb-3">
                    <img width="150" id="frame" height="150" class="img-fluid" src="{{ asset('images/avatar.png') }}" alt="">
                    </div>

                <div class="form-group mb-3 d-grid">
                    <button type="submit" id="teacheregbtn" class="btn btn-info">REGISTER PARENT/GUARDIAN</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    </div>
</div>

<div class="row border border-3 border-info p-3">
    
<div class="table-responsive">
<div id="actionbtns" class="mb-2">
<button id="deactivatebtn" class="btn btn-sm btn-primary float-end m-1">Deactivate</button>
<button id="activatebtn" class="btn btn-sm btn-success float-end m-1">Activate</button>
<button id="viewbtn" class="btn btn-sm btn-info float-end m-1"><i class="fas fa-eye"></i>&nbsp;View</button>
<button id="editbtn" class="btn btn-sm btn-warning float-end m-1"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
<button id="delbtn" class="btn btn-sm btn-danger float-end m-1"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button> 
</div> 
<table class="table" id="parentstable">
            <thead>
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Account Active?</th>
                <th scope="col">Gender</th>
                <th scope="col">Phone</th>
                <th scope="col">Alt Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Student Admission Number(s)</th>  
            </tr>
        </thead>
        <tbody id="parentstablebody">
            
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
        fetchparents();
        fecthclasses();

        //set csrf
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        //select students to filter
        $('#studentfilter').change(function(e){
            e.preventDefault();
            var sid = "{{ session()->get('schooldetails.id') }}";
            var value = $(this).val()
            var filter = {
                'filtervalue' : value
            }

                $.ajax({
                    method: 'GET',
                    url: `/filterStudents/${value}/${sid}`,
                    success: function(res){
                            $('#filtredstudents').removeClass('d-none');
                            $('#parentsstudent').html('')
                            if (res.students.length == 0) {
                                $('#parentsstudent').append('<h6 class="text-center text-danger">No students Found</h6>');
                            } else {
                            $.each(res.students, function(key,item){
                            $('#parentsstudent').append('<tr>\
                            <td><input value="'+(item.UPI == null ? item.AdmissionNo : item.UPI)+'" id="childreg" type="checkbox" name="childreg"></td>\
                            <td>'+(item.UPI == null ? item.AdmissionNo+' <b class="text-danger">(Adm No.)</b>' : item.UPI+' <b class="text-success">(UPI)</b>')+'</td>\
                            <td>'+item.Fname+' '+item.Lname+'</td>\
                            </tr>');
                        })
                    }

                        //$("#studentselecttable").DataTable().fnDestroy()
                        $("#studentselecttable").DataTable().fnDestroy()
                        
                        $('#studentselecttable').DataTable({
                        ordering: false,
                        paging: false,
                        searching: true
                         });
                         
                    }
                    }) 
                    })
        //select students to edit
        $('#editstudentfilter').change(function(e){
            e.preventDefault();
            var sid = "{{ session()->get('schooldetails.id') }}";
            var value = $(this).val()
            var filter = {
                'filtervalue' : value
            }

                $.ajax({
                    method: 'GET',
                    url: `/filterStudents/${value}/${sid}`,
                    success: function(res){
                            //$('#filtredstudents').removeClass('d-none');
                            $('#editparentsstudent').html('')
                            $.each(res.students, function(key,item){
                            $('#editparentsstudent').append('<tr>\
                            <td><input value="'+(item.UPI == null ? item.AdmissionNo : item.UPI)+'" id="editchildreg" type="checkbox" name="editchildreg"></td>\
                            <td>'+(item.UPI == null ? item.AdmissionNo+' <b class="text-danger">(Adm No.)</b>' : item.UPI+' <b class="text-success">(UPI)</b>')+'</td>\
                            <td>'+item.Fname+' '+item.Lname+'</td>\
                            </tr>');
                        })

                        $("#editstudentselecttable").DataTable().fnDestroy()

                        $('#editstudentselecttable').DataTable({
                        ordering: false,
                        paging: false,
                        searching: true
                         });

                    }
                    }) 
                    })            
               // })
       // })
        //fetch classes
        function fecthclasses(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses/${sid}`,
                success: function(res){
                    if (res.classes.length == 0) {
                        $('#studentfilter').html('');
                        $('#studentfilter').html('<h5 class="text-danger">There are no classes registered yet</h5>')
                    } else {
                        $('#studentfilter').html('');
                        $('#studentfilter').append('<option value="">Select Class</option>');
                        $('#studentfilter').append('<option value="ALL">ALL</option>');
                        $.each(res.classes, function(key,item){
                            $('#studentfilter').append('<option value="'+item.id+'">'+item.class+' '+(item.stream == null ? "" : item.stream)+'</option>');
                        })
                    }
                }
            });
        }
        //fetch for updatting
        function fecthclasses2(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses/${sid}`,
                success: function(res){
                    if (res.classes.length == 0) {
                        $('#editstudentfilter').html('');
                        $('#editstudentfilter').html('<h5 class="text-danger">There are no classes registered yet</h5>')
                    } else {
                        $('#editstudentfilter').html('');
                        $('#editstudentfilter').append('<option value="">Select Class</option>');
                        $('#editstudentfilter').append('<option value="ALL">ALL</option>');
                        $.each(res.classes, function(key,item){
                            $('#editstudentfilter').append('<option value="'+item.id+'">'+item.class+' '+(item.stream == null ? "" : item.stream)+'</option>');
                        })
                    }
                }
            });
        }

        function fetchparents() {
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchparents/${sid}`,
                //dataType: 'jsons',
                success: function(res) {
                    if (res.parents.length == 0) {
                        $('#parentstablebody').html('<h5 class="text-center text-danger">No any parents registered as at now</h5>');
                    } else {
                        $('#parentstablebody').html('');
                         $.each(res.parents, function(key,item){
                            $('#parentstablebody').append('<tr>\
                            <td><input value="'+item.id+'" type="checkbox" class="parentcheckbox" name="" id="parentcheckbox"></td>\
                            <td><img  width="50" height="50" class="img-fluid" src="images/'+item.Profile+'" alt=""></td>\
                            <td>'+item.Fname+' '+item.Lname+'</td>\
                            <td><button class="btn btn-success btn-sm">'+item.Active+'</button></td>\
                            <td>'+item.Gender+'</td>\
                            <td>'+item.Phone+'</td>\
                            <td>'+(item.AltPhone == null ? "No Alternative Number" : item.AltPhone)+'</td>\
                            <td>'+(item.Email == null ? "No Email" : item.Email)+'</td>\
                            <td>'+item.Students+'</td>\
                            </tr>')
                    }); 

                    $("#parentstable").DataTable().fnDestroy()

                        $('#parentstable').DataTable({
                        ordering: false,
                        paging: false,
                        searching: true
                         });

                    }  
                }
            })          
        }

        $(document).on('change', '.parentcheckbox',function(e){
            e.preventDefault();
            var id = $(this).val();
            $('#actionbtns').removeClass('d-none');
        })

        $("#parentregform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($('#parentregform'))
            $('#regresponse').addClass('d-none');
            $('#teacheregbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#parentregform')[0]);
            
            var admno = [];
            $('#childreg:checked').each(function(i){
                admno[i] = $(this).val()
            })  
           formData.append('admsions', admno);

            $.ajax({
                method: 'POST',
                url: '{{ route('guardian.register') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   if (res.status == 400) {
                    $('#teacheregbtn').val('REGISTER TEACHER');
                    showError('firstname', res.messages.firstname);
                    showError('secondname', res.messages.secondname);
                    showError('lastname', res.messages.lastname);
                    showError('phone', res.messages.phone);
                    showError('altphone', res.messages.altphone);
                    showError('email', res.messages.email);
                    showError('gender', res.messages.gender);
                    showError('file', res.messages.file);
                    $('#unselectedstudents').removeClass('d-none');
                    $('#unselectedstudents').text(res.messages.admsions);
                   } else if(res.status == 200){
                    removeValidationClasses($('#parentregform'))
                    fetchparents();
                    $('#parentregform')[0].reset();
                    $('#teacheregbtn').val('REGISTER TEACHER');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#regresponse').removeClass('d-none');
                    //$('#teacherregform').find('input').val('');
                   $('#frame').src = 'images/avatar.png';
                   $("#teacheraddModal").modal('hide'); 
                   }   
               }
            });
        })
    //submit update form ajax
    $("#parenteditform").submit(function(e){
            e.preventDefault();
            $('#regresponse').addClass('d-none');
            $('#editsubmitbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#parenteditform')[0]);
            
            var admno = [];
            $('#editchildreg:checked').each(function(i){
                admno[i] = $(this).val()
            })  
           formData.append('admsions', admno);

            $.ajax({
                method: 'POST',
                url: '{{ route('guardian.edit') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   //console.log(res)
                   if (res.status == 400) {
                    $('#editsubmitbtn').val('EDIT PARENT/GUARDIAN');
                    showError('editfname', res.messages.editfname);
                    showError('editsname', res.messages.editsname);
                    showError('editlname', res.messages.editlname);
                    showError('editphone', res.messages.editphone);
                    showError('altphone', res.messages.altphone);
                    showError('editemail', res.messages.editemail);
                    showError('editgender', res.messages.editgender);
                    showError('editprofile', res.messages.editprofile);
                    $('#editunselectedstudents').removeClass('d-none');
                    $('#editunselectedstudents').text(res.messages.admsions);
                   } else if(res.status == 200){
                    fetchparents();
                    $('#parenteditform')[0].reset();
                    $('#editsubmitbtn').val('EDIT PARENT/GUARDIAN');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#regresponse').removeClass('d-none');
                    //$('#teacherregform').find('input').val('');
                   $('#frame').src = 'images/avatar.png';
                   $("#parentupdateModal").modal('hide'); 
                   }   
               }
            });
        })

    //Function to fetch student for update
    function fetchparent2(id){
        $.ajax({
                method: 'GET',
                url: `/getparent/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                var data = res.parent;
                $('#parentimg2').html('');
                $('#parentimg2').append('<img height="150" width="150" src="images/'+data.Profile+'" class="img-fluid"/>');
                $('#titleparent').text(data.Fname+' '+data.Sname+' '+data.Lname);
                $('#parentdetails').html('');
                $('#parentdetails').append('<div class="row">\
                    <h6>First Name : <span class="text-danger">'+data.Fname+'</span></h6>\
                    <h6>Second Name : <span class="text-danger">'+data.Sname+'</span></h6>\
                    <h6>Last Name : <span class="text-danger">'+data.Lname+'</span></h6>\
                    <h6>Parent/Guardian? : <span class="text-danger">'+data.Parent_Guardian+'</span></h6>\
                    <h6>Gender : <span class="text-danger">'+data.Gender+'</span></h6>\
                    <h6>Phone Number : <span class="text-danger">'+data.Phone+'</span></h6>\
                    <h6>Alternative Phone : <span class="text-danger">'+data.AltPhone+'</span></h6>\
                    <h6>Email address : <span class="text-danger">'+data.Email+'</span></h6>\
                    <h6>Username : <span class="text-danger">'+data.username+'</span></h6>\
                    <h6>Admission Number(s) of Child/Children : <span class="text-danger">'+data.Students+'</span></h6>\
                </div>');
                }
            })
        }
        //Function to fetch student for update
    function fetchparent(id){
        $.ajax({
                method: 'GET',
                url: `/getparent/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                var data = res.parent;
                //console.log(data)
                $('#parentimg').html('<img width="150" id="frame2" height="150" class="img-fluid" src="images/'+data.Profile+'" alt="">');
                $('#editid').val(data.id);
                $('#editfname').val(data.Fname)
                $('#editsname').val(data.Sname)
                $('#editlname').val(data.Lname)
                $('#editparval').val(data.Parent_Guardian)
                $('#editparval').text(data.Parent_Guardian)
                $('#editphone').val(data.Phone)
                $('#editaltphone').val(data.AltPhone)
                $('#editemail').val(data.Email)
                
                if (data.Gender == 'Male') {
                    $('#genderdiv').html('');
                    $('#genderdiv').append('<input checked type="radio" name="editgender" id="editgender" value="Male">&nbsp;Male\
                        <input type="radio" name="editgender" id="editgender" value="Female">&nbsp;Female');
                } else {
                    $('#genderdiv').html('');
                    $('#genderdiv').append('<input type="radio" name="editgender" id="editgender" value="Male">&nbsp;Male\
                        <input checked type="radio" name="editgender" id="editgender" value="Female">&nbsp;Female'); 
                }

                }
            })
        }
     //Teacher Update
     $(document).on('click', '#editbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#parentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a parent/guardian to edit');
        } else if(ids.length > 1){
            alert('You can only edit one parent/guardian at a time. Select only one parent/guardian');
        } else {
            fecthclasses2()
            fetchparent(ids)
           $('#parentupdateModal').modal('show'); 
        }
     })
     //Teacher Viewing
     $(document).on('click', '#viewbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#parentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a Parent to view details');
        } else if(ids.length > 1){
            alert('You can only view one Parent at a Time.Select only one Parent');
        } else {
            fetchparent2(ids)
           $('#parentviewModal').modal('show'); 
        }
     })
     //Student deactivating account ajax
    $(document).on('click', '#deactivatebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#parentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Parent(s) whose account(s) is/are to be deactivated')
        } else {
            var confirm = window.confirm(`Are you sure you want to Deactivate this Parents' Account? Once you deactivate they will not be able to login`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deactivateparent/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                    $('#regresponse').removeClass('d-none');
                   if (res.status == 200) {
                    fetchparents();
                    fecthclasses();
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
        }
     })
      //Parent activating account ajax
    $(document).on('click', '#activatebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#parentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Parent(s) whose account(s) is/are to be activated')
        } else {
            var confirm = window.confirm(`Are you sure you want to activate this Parent's Account? Once you activate they will not be able to login to the System`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/activateparent/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchparents();
                    fecthclasses();
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
//Teacher deleting ajax
$(document).on('click', '#delbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#parentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Parent(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this Parent? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deleteparent/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchparents();
                    fecthclasses();
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