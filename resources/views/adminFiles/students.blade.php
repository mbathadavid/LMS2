@extends('layouts.layout')

@section('title','Students')

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
<h4>Student(s)</h4>
<div class="mb-2">
<button class="btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#teacheraddModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD STUDENT</button>
<a href="/downloadstudents" class="btn btn-sm btn-info" type="button">EXPORT TO EXCEL</a>
<button class="btn-sm btn-primary" type="button">IMPORT FROM EXCEL</button>
<!--
<h6 id="regresponse" class="bg-info text-center text-success d-none text-success p-1 mt-1 mb-1"></h6>
--->
<div id="regresponse"></div>
</div>
<!---Student Edit modal start--->
<div class="modal w3-animate-zoom" id="studentupdateModal" tabindex="-1" aria-labelledby="studentupdateModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center">Student Update Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       <form method="POST" action="#" id="studenteditform" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6">
            <input hidden type="number" name="sid" id="sid" value="{{ session()->get('schooldetails.id') }}">
            <input type="number" name="seditid" id="seditid" hidden>
                <div class="form-group mb-2">
                <label for="">Admission Number</label>
                <input class="form-control" type="number" name="seditadmno" id="seditadmno">
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">First Name</label>
                <input class="form-control" type="text" name="seditfname" id="seditfname">
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Second Name</label>
                <input class="form-control" type="text" name="seditsname" id="seditsname">
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Last Name</label>
                <input class="form-control" type="text" name="seditlname" id="seditlname">
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <div id="genderdiv">

                </div>
                <div class="invalid-feedback"></div>
                </div>
                <div class="form-group mb-2">
                <label for="">Current Class</label>
                <select class="form-control" name="seditclass" id="seditclass">
                    <option id="seditclassval"></option>
                </select>
                </div>
            </div>
            <div class="col-lg-6">
            <div class="form-group mb-2">
                <label for="">Date of Birth</label>
                <input class="form-control" type="date" name="seditdob" id="seditdob">
                <div class="invalid-feedback"></div>
            </div> 
            <div class="form-group mb-2">
                <label for="">County of origin</label>
                <input class="form-control" type="text" name="seditcounty" id="seditcounty">
            </div> 
            <div class="form-group mb-2">
                <label for="">SubCounty of Origin</label>
                <input class="form-control" type="text" name="seditscounty" id="seditscounty">
                <div class="invalid-feedback"></div>
            </div> 
            <div class="form-group mb-2">
                <label for="">Disabled?</label>
                <select class="form-control" name="seditdisability" id="seditdisability">
                 <option id="editdisabilityval"></option>
                 <option value="Yes">Yes</option>
                <option value="No">No</option>
                </select>
                <div class="invalid-feedback"></div>
            </div> 
            <div id="disabilitytypediv2" class="form-group mb-1 d-none">
                <label for="">Select type of Disability</label>
                <select class="form-control" name="editdisabilitytype" id="editdisabilitytype">
                <option id="seditdistype"></option>
                <option value="Visually Impared">Visually Impared</option>
                <option value="Hearing Imparement">Hearing Imparement</option>
                <option value="Physically Impared">Physically Impared</option>
                <option value="Other">Other</option>
                </select>
                <div class="invalid_feedback"></div>
                </div>
            <div class="form-group mb-2">
                <label for="">Profile Photo</label>
                <input onchange="preview2()" class="form-control" type="file" name="seditprofile" id="seditprofile">
                <div class="invalid-feedback"></div>
            </div>
            </div>

            <div id="disdesdiv2" class="form-group mb-1 d-none">
            <label for="">Disability Description</label>
            <textarea placeholder="Give details of the disability" class="form-control" name="seditdisabilitydescription" id="seditdisabilitydescription">

            </textarea>
            <div class="invalid-feedback"></div>
            </div>

            <div id="seditimgdiv" class="text-center mb-1">
                
            </div>

            <div class="form-group mb-3 d-grid">
                <button type="submit" id="sedtbtn" class="btn btn-warning">EDIT STUDENT</button>
            </div> 

        </div>
       </form>
        </div>
    </div>
    </div>
</div>
<!---Student Edit modal start--->

<!---Student View modal start--->
<div class="modal w3-animate-zoom" id="studentviewModal" tabindex="-1" aria-labelledby="promoteStudentModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel"><span id="titleadm" class="text-danger"></span> Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="text-center" id="studentimg"></div>
         <div class="col-lg-4 p-2">
             <h5 class="text-center text-info">General Information</h5>
            <h6>Admission Number : <span id="viewadmno" class="text-success"></span></h6>
            <h6>First Name : <span id="viewfname" class="text-success"></span></h6>
            <h6>Second Name : <span id="viewsname" class="text-success"></span></h6>
            <h6>Last Name : <span id="viewlname" class="text-success"></span></h6>
            <h6>Current Class : <span id="viewclass" class="text-success"></span></h6>
            <h6>Gender : <span id="viewgender" class="text-success"></span></h6>
            <h6>Date of Birth : <span id="viewdob" class="text-success"></span></h6>
            <h6>Account Active? : <span id="viewstatus" class="text-success"></span></h6>
            <h6>County of Origin : <span id="viewcounty" class="text-success"></span></h6>
            <h6>Sub County of Origin : <span id="viewscounty" class="text-success"></span></h6>
         </div>
         <div class="col-lg-4 p-2">
            <h5 class="text-center text-info">Disability Issues</h5>
            <h6>Disabled? : <span id="viewdisabled" class="text-success"></span></h6>
            <h6 id="viewdis">Type of Disabilty : <span id="viewdisability" class="text-success"></span></h6>
            <h6 id="viewddes">Disability Description : <span id="viewddescription" class="text-success"></span></h6>
         </div>
         <div class="col-lg-4 p-2">
            <h5 class="text-center text-info">Parent/Guardian information</h5>
            <div id="parentinfo">

            </div>
         </div>
        </div>
        </div>
    </div>
    </div>
</div>
<!---Student View modal start--->

<!---Student Promote Modal--->
<div class="modal w3-animate-zoom" id="promoteStudentModal" tabindex="-1" aria-labelledby="promoteStudentModal">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Promote Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="studentpromoteform" class="p-2" method="POST" enctype="multipart/form-data">
           <div class="form-group mb-2">
            <label for="">Select Class</label>
            <select class="form-control" name="nextclass" id="nextclass">
                <option value="">--select class--</option>
            </select>
            <div id="nextclassres" class="invalid-feedback text-danger"></div>
           </div> 
           <div class="form-group d-grid">
            <input id="studentpromotebtn" class="btn btn-sm btn-primary rounded-0" type="submit" value="PROMOTE STUDENTS">
           </div>
        </form>
            </div>
    </div>
    </div>
</div>
<!---Student Promote Modal--->
<div class="modal fade" id="teacheraddModal" tabindex="-1" aria-labelledby="teacheraddModalLabel">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Register Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="studentregform" class="p-2" method="POST" enctype="multipart/form-data">
            <div class="row">
                <input hidden type="number" name="sid" id="sid" value="{{ session()->get('schooldetails.id') }}">
                <div class="col-lg-6">
                    
                    <div class="form-group mb-1">
                        <label for="">Admission Number</label>
                        <input placeholder="Admission Number" type="text" name="admissionNo" id="admissionNo" class="form-control">
                        <div class="invalid-feedback"></div>  
                    </div>
                    <div class="form-group mb-1">
                        <label for="">First Name</label>
                        <input placeholder="First Name" type="text" name="firstname" id="firstname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="">Second Name</label>
                        <input placeholder="Second Name" type="text" name="secondname" id="secondname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="">Last Name</label>
                        <input placeholder="Last Name" type="text" name="lastname" id="lastname" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="">Gender</label><br>
                        <input type="radio" name="gender" id="gender" value="male">&nbsp;Male
                        <input type="radio" name="gender" id="gender" value="female">&nbsp;Female
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="">Current Class</label>
                        <select class="form-control" name="current_class" id="current_class">
                            <option value="">--select class--</option>
                            
                            </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <!--
                    <div class="form-group mb-1">
                        <input type="checkbox" value="active" name="active" id="active">&nbsp; Active
                        <div class="invalid-feedback"></div>
                    </div>
                    --->
                </div>
                

                <div class="col-lg-6">
                <div class="form-group mb-1">
                        <label for="">Date of Birth</label>
                        <input placeholder="Date of Birth" type="date" name="dob" id="dob" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="">County of Origin</label>
                        <input placeholder="Your County of origin" type="text" name="county" id="county" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="">Sub County</label>
                        <input placeholder="Sub County" type="text" class="form-control" name="subcounty" id="subcounty">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="form-group mb-1">
                        <label for="">Disabled?</label>
                        <select class="form-control" name="disabled" id="disabled">
                        <option value="">--select Yes/No</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        </select>
                        <div class="invalid_feedback"></div>
                    </div>

                    <div id="disabilitytypediv" class="form-group mb-1 d-none">
                        <label for="">Select type of Disability</label>
                        <select class="form-control" name="disabilitytype" id="disabilitytype">
                        <option value="">--select Disability</option>
                        <option value="Visually Impared">Visually Impared</option>
                        <option value="Hearing Imparement">Hearing Imparement</option>
                        <option value="Physically Impared">Physically Impared</option>
                        <option value="Other">Other</option>
                        </select>
                        <div class="invalid_feedback"></div>
                    </div>

                    <div class="form-group mb-1">
                        <label for="">Profile Photo</label><br>
                        <input onchange="preview()" type="file" name="file" id="file" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                    <div id="disdesdiv" class="form-group mb-1 d-none">
                    <label for="">Disability Description</label>
                    <textarea placeholder="Give details of the disability" class="form-control" name="disabilitydescription" id="disabilitydescription">

                    </textarea>
                    <div class="invalid-feedback"></div>
                    </div>

                    <div class="text-center mb-1">
                    <img width="150" id="frame" height="150" class="img-fluid" src="{{ asset('images/avatar.png') }}" alt="">
                    </div>

                <div class="form-group mb-3 d-grid">
                    <button type="submit" id="teacheregbtn" class="btn btn-info">REGISTER STUDENT</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    </div>
</div>

<div class="row border border-3 border-info p-3">
    
<div class="table-responsive">
<div id="actionbtns" class="d-none mb-2 d-flex float-end">
<button id="promotebtn" class="btn btn-sm btn-warning m-1">Promote Student</button>
<button id="clearbtn" class="btn btn-sm btn-info m-1">Clear Student</button>
<button id="deactivatebtn" class="btn btn-sm btn-primary m-1">Deactivate</button>
<button id="activatebtn" class="btn btn-sm btn-success m-1">Activate</button>
<button id="examsbtn" class="btn btn-sm btn-danger m-1">View Results</button>
<button id="viewfeesbtn" class="btn btn-sm btn-primary m-1">Fee Information</button>
<button id="viewbtn" class="btn btn-sm btn-info m-1"><i class="fas fa-eye"></i>&nbsp;View</button>
<button id="editbtn" class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
<button id="deletebtn" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button> 
</div> 
<table id="studentstable" class="table">
            <thead>
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Image</th>
                <th scope="col">Admission No.</th>
                <th scope="col">Name</th>
                <th scope="col">Account Active?</th>
                <th scope="col">Gender</th>
                <th scope="col">Class</th>
                <th scope="col">School System</th>
                <th scope="col">Disabled?</th>
                <th scope="col">DoB</th>
                <th scope="col">County</th>
                <th scope="col">Sub-County</th>
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
        fetchstudents();
        fecthclasses()

        //set csrf
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        //selecting disability type
        $('#disabled').change(function(e){
            e.preventDefault();
            var value = $(this).val()
            if (value == 'Yes') {
                $('#disabilitytypediv').removeClass('d-none');
            } else if(value == 'No'){
                $('#disabilitytypediv').addClass('d-none');
            }
        })
        //selecting disability when updating
        $('#seditdisability').change(function(e){
            e.preventDefault();
            var value = $(this).val()
            if (value == 'Yes') {
                $('#disabilitytypediv2').removeClass('d-none');
                $('#disdesdiv2').removeClass('d-none');
            } else if(value == 'No'){
                $('#disabilitytypediv2').addClass('d-none');
                $('#disdesdiv2').addClass('d-none');
                $('#seditdisabilitydescription').val('');
            }
        })

        //showing disability description
        $("#disabilitytype").change(function(e){
            e.preventDefault()
            var value = $(this).val()
            if (value == 'Other') {
               $('#disdesdiv').removeClass('d-none'); 
            } else {
                $('#disdesdiv').addClass('d-none'); 
            }
        })
        //showing disability description
        $("#editdisabilitytype").change(function(e){
            e.preventDefault()
            var value = $(this).val()
            if (value == 'Other') {
                $('#disdesdiv2').removeClass('d-none');
                $('#seditdisabilitydescription').val('');
            } else {
                $('#disdesdiv2').addClass('d-none');
            }
        })

        //Function to fetch student
        function fetchstudent(id){
        $.ajax({
                method: 'GET',
                url: `/getstudent/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.student;
                    $('#titleadm').text(data.AdmissionNo+' '+data.Fname+' '+data.Lname);
                    $('#studentimg').html('<img src="images/'+data.profile+'" class="img-fluid"/>');
                    $('#viewadmno').text(data.AdmissionNo)
                    $('#viewfname').text(data.Fname)
                    $('#viewsname').text(data.Sname)
                    $('#viewlname').text(data.Lname)
                    $('#viewgender').text(data.gender)
                    $('#viewdob').text(data.dob)
                    $('#viewclass').text(data.current_class)
                    $('#viewstatus').text(data.Active)
                    $('#viewcounty').text(data.county)
                    $('#viewscounty').text(data.subcounty)
                    $('#viewdisabled').text(data.disabled)
                    if (data.disabled == 'No') {
                    $('#viewdis').addClass('d-none')
                    $('#viewddes').addClass('d-none')  
                    } else {
                    $('#viewdisability').text(data.disability)
                    $('#viewddescription').text(data.d_description)  
                    }
                    if (data.parentinfo == null) {
                        $("#parentinfo").html('');
                        $('#parentinfo').append('<h6 class="text-danger">Students parent information has not yet been added</h6>')
                    } else {
                        $("#parentinfo").html('');
                        $('#parentinfo').append('<h6>Parent/Guardian? <span class="text-danger">'+data.parentinfo.split(',')[2]+'</span></h6>\
                        <h6>First Name : <span class="text-danger">'+data.parentinfo.split(',')[0]+'</h6>\
                        <h6>Last Name : <span class="text-danger">'+data.parentinfo.split(',')[1]+'</span></h6>\
                        <h6>Phone Number : <span class="text-danger">'+data.parentinfo.split(',')[3]+'</span></h6>\
                        <h6>Email : <span class="text-danger">'+data.parentinfo.split(',')[4]+'</span></h6>\
                        ')
                        
                    }
                }                   
                })
        }
        //Function to fetch student for update
        function fetchstudent2(id){
        $.ajax({
                method: 'GET',
                url: `/getstudent/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                var data = res.student;
                console.log(data)
                $('#seditimgdiv').html('');
                $('#seditimgdiv').html('<img width="150" id="frame2" height="150" class="img-fluid" src="images/'+data.profile+'" alt="">');
                $('#seditid').val(data.id);
                $('#seditadmno').val(data.AdmissionNo);
                $('#seditfname').val(data.Fname);
                $('#seditsname').val(data.Sname);
                $('#seditlname').val(data.Lname);
                $('#seditdob').val(data.dob);
                $('#seditcounty').val(data.county);
                $('#seditclassval').val(data.current_class)
                $('#seditclassval').text(data.current_class)
                $('#seditscounty').val(data.subcounty);
                $('#seditdisabilitydescription').val(data.d_description);
                $('#editdisabilityval').val(data.disabled);
                $('#editdisabilityval').text(data.disabled);

                if (data.gender == 'male') {
                    $('#genderdiv').html('');
                    $('#genderdiv').html('<label for="">Gender</label><br>\
                        <input checked type="radio" name="seditgender" id="seditgender" value="male">&nbsp;Male\
                        <input type="radio" name="seditgender" id="seditgender" value="female">&nbsp;Female');
                } else {
                    $('#genderdiv').html('');
                    $('#genderdiv').html('<label for="">Gender</label><br>\
                        <input type="radio" name="seditgender" id="seditgender" value="male">&nbsp;Male\
                        <input checked type="radio" name="seditgender" id="seditgender" value="female">&nbsp;Female'); 
                }
                 
                if (data.disabled == 'Yes') {
                    $('#disabilitytypediv2').removeClass('d-none');
                    $('#seditdistype').text(data.disability)
                    $('#seditdistype').val(data.disability)
                } else {
                    $('#disabilitytypediv2').addClass('d-none'); 
                }

                if (data.disability == 'Other') {
                    $('#disdesdiv2').removeClass('d-none');
                    $('#seditdisabilitydescription').removeClass('d-none');
                    $('#seditdisabilitydescription').val(data.d_description);
                } else {
                    $('#disdesdiv2').addClass('d-none');
                }

                }
            })
        }   


        //fetch classes
        function fecthclasses(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses/${sid}`,
                success: function(res){
                    console.log(res)
                    if (res.classes.length == 0) {
                        $('#current_class').html('');
                        $('#current_class').html('<h5 class="text-danger">There are no classes registered yet</h5>')
                    } else {
                        $('#current_class').html('');
                        $.each(res.classes, function(key,item){
                            $('#current_class').append('<option value="'+item.id+','+item.class+' '+item.stream+'">'+item.class+' '+(item.stream == null ? "" : item.stream)+'</option>');
                        })
                    }
                }
            });
        }
        //fetch classes for update
        function fecthclasses3(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses/${sid}`,
                success: function(res){
                    console.log(res)
                    if (res.classes.length == 0) {
                        $('#seditclass').html('');
                        $('#seditclass').html('<h5 class="text-danger">There are no classes registered yet</h5>')
                    } else {
                        $('#seditclass').html('');
                        $.each(res.classes, function(key,item){
                            $('#seditclass').append('<option value="'+item.id+','+item.class+' '+item.stream+'">'+item.class+' '+(item.stream == null ? "" : item.stream)+'</option>');
                        })
                    }
                }
            });
        }

        //fetch classes two
        function fecthclasses2(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchclasses/${sid}`,
                success: function(res){
                    console.log(res)
                    if (res.classes.length == 0) {
                        $('#nextclass').html('');
                        $('#nextclass').html('<h5 class="text-danger">There are no classes registered yet</h5>')
                    } else {
                        $('#nextclass').html('');
                        $.each(res.classes, function(key,item){
                            $('#nextclass').append('<option value="'+item.id+','+item.class+' '+(item.stream == null ? "" : item.stream)+'">'+item.class+' '+item.stream+'</option>');
                        })
                    }
                }
            });
        }

        //fetch students
        function fetchstudents() {
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchstudents/${sid}`,
                //dataType: 'jsons',
                success: function(res) {
                    if (res.students.length == 0) {
                        $('tbody').html('<h5 class="text-center text-danger">No any students registered as at now</h5>');
                    } else {
                        $('tbody').html('');
                         $.each(res.students, function(key,item){
                        $('tbody').append('<tr>\
                        <td><input value="'+item.id+'" type="checkbox" class="checkboxid" name="studentcheckbox" id="studentcheckbox"></td>\
                        <td><img  width="50" height="50" class="img-fluid" src="images/'+item.profile+'" alt=""></td>\
                        <td>'+item.AdmissionNo+'</td>\
                        <td>'+item.Fname+' '+item.Lname+'</td>\
                        <td><button class="btn btn-success btn-sm">'+item.Active+'</button></td>\
                        <td>'+item.gender+'</td>\
                        <td>'+(item.current_class === "completed" ? "<b class='text-danger'>Completed</b>" : item.current_class )+'</td>\
                        <td>'+item.schoolsystem+'</td>\
                        <td>'+item.disabled+'</td>\
                        <td>'+item.dob+'</td>\
                        <td>'+item.county+'</td>\
                        <td>'+item.subcounty+'</td>\
                    </tr>');
                    });  

                    $("#studentstable").DataTable().fnDestroy()

                        $('#studentstable').DataTable({
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
        //Register Student ajax Request
        $("#studentregform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($('#studentregform'))
            $('#regresponse').addClass('d-none');
            $('#teacheregbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#studentregform')[0]);

            $.ajax({
                method: 'POST',
                url: '{{ route('student.register') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   if (res.status == 400) {
                    $('#teacheregbtn').val('REGISTER STUDENT');
                    showError('admissionNo', res.messages.admissionNo);
                    showError('firstname', res.messages.firstname);
                    showError('lastname', res.messages.lastname);
                    showError('secondname', res.messages.secondname);
                    showError('gender', res.messages.gender);
                    showError('current_class', res.messages.current_class);
                    showError('county', res.messages.county);
                    showError('subcounty', res.messages.subcounty);
                    showError('file', res.messages.file);
                   } else if(res.status == 401){
                    showError('admissionNo', res.messages);
                   } else if(res.status == 200) {
                    removeValidationClasses($('#studentregform'))
                    fetchstudents();
                    $('#studentregform')[0].reset();
                    $('#teacheregbtn').val('REGISTER STUDENT');
                    //$('#regresponse').text(res.messages)
                    $('#regresponse').removeClass('d-none');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#frame').src = 'images/avatar.png';
                    $("#teacheraddModal").modal('hide');
                   }
                   
               } 
            });
        })

    //Edit Student ajax Request
    $("#studenteditform").submit(function(e){
            e.preventDefault();
            $('#regresponse').addClass('d-none');
            $('#sedtbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#studenteditform')[0]);

            $.ajax({
                method: 'POST',
                url: '{{ route('student.edit') }}',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                   if (res.status == 400) {
                    $('#sedtbtn').val('EDIT STUDENT');
                    showError('seditadmno', res.messages.seditadmno);
                    showError('seditfname', res.messages.seditfname);
                    showError('seditsname', res.messages.seditsname);
                    showError('seditlname', res.messages.seditlname);
                    showError('seditdob', res.messages.seditdob);
                    showError('seditscounty', res.messages.seditscounty);
                    showError('seditcounty', res.messages.seditcounty);
                    showError('seditdisability', res.messages.seditdisability);
                    showError('editdisabilitytype', res.messages.editdisabilitytype);
                    showError('seditprofile', res.messages.seditprofile);
                   } else if(res.status == 200){
                    fetchstudents();
                    $('#studenteditform')[0].reset();
                    $('#sedtbtn').val('EDIT STUDENT');
                    //$('#regresponse').text(res.messages)
                    $('#regresponse').removeClass('d-none');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   $('#frame').src = 'images/avatar.png';
                   $("#studentupdateModal").modal('hide'); 
                   } 
                   
               } 
            });
        })

    //Student Clearing ajax
    $(document).on('click', '#clearbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Student(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to clear Student/s? You will not be able to revert this action one executed.Students should only be cleared after completing school.`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/clearstudent/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    fetchstudents();
                    fecthclasses()
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

    //Student deleting ajax
     $(document).on('click', '#deletebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Student(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this Student? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deletestudent/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    fetchstudents();
                    fecthclasses()
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
     //Student Promote Ajax
     $(document).on('click', '#promotebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Student(s) to promote')
        } 
        else {
            fecthclasses2()
            $('#promoteStudentModal').modal('show');  
        }
     })
    //promote students
    $('#studentpromoteform').submit(function(e){
        e.preventDefault();
        var nextclass = $('#nextclass').val()
        $('#studentpromotebtn').val('PROMOTING STUDENTS...');
        var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (nextclass == "") {
            $('#nextclass').addClass('is-invalid');
            $('#nextclassres').text('You must select a class where you want to promote the students to.');
            $('#studentpromotebtn').val('PROMOTE STUDENTS');
        } else {
            $.ajax({
                method: 'GET',
                url: `/promotestudent/${ids}/${nextclass}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                   if (res.status == 200) {
                    $('#promoteStudentModal').modal('hide');  
                    fetchstudents();
                    fecthclasses()
                    $('#regresponse').removeClass('d-none');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
        } 
    })
    //Student deactivating account ajax
    $(document).on('click', '#deactivatebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Student(s) whose account(s) is/are to be deactivated')
        } else {
            var confirm = window.confirm(`Are you sure you want to Deactivate this Student Account? Once you deactivate they will not be able to login`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deactivatestudent/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    fetchstudents();
                    fecthclasses()
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
     //Student activating account ajax
    $(document).on('click', '#activatebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a Student(s) whose account(s) is/are to be activated')
        } else {
            var confirm = window.confirm(`Are you sure you want to activate this Student Account? Once you activate they will not be able to login to the System`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/activatestudent/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    console.log(res)
                   if (res.status == 200) {
                    fetchstudents();
                    fecthclasses()
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
     //Student Exam Viewing
     $(document).on('click', '#viewbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a student to view details');
        } else if(ids.length > 1){
            alert('You can only view one student at a Time.Select only one student');
        } else {
            fetchstudent(ids)
           $('#studentviewModal').modal('show'); 
        }
     })
     //Student Update
     $(document).on('click', '#editbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a student to edit');
        } else if(ids.length > 1){
            alert('You can only edit one student at a time. Select only one student');
        } else {
            fetchstudent2(ids)
            fecthclasses3()
           $('#studentupdateModal').modal('show'); 
        }
     })

    })
</script>
@endsection