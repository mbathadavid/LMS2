<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontcss/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Schools</title>
</head>
<body>
<!---School add Alert modal start--->
<div class="modal w3-animate-zoom" id="schooladdAlertModal" tabindex="-1" aria-labelledby="schooladdAlertModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Add Alert Modal<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="schooladdalertform" method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <input type="text" name="alertschools" id="alertschools" class="form-control" hidden>
            <div class="form-group mb-2">
                <label for="">Enter Alert</label>
                <textarea name="alertmessage" id="alertmessage" cols="30" rows="10" class="form-control">

                </textarea>
            </div>
            <input id="alertsubmitbtn" type="submit" value="SUBMIT ALERT" class="form-control btn btn-info">
            </form>
        </div>
    </div>
    </div>
</div>
<!---School add Alert modal End--->

<!---School edit modal start--->
<div class="modal w3-animate-zoom" id="schooleditModal" tabindex="-1" aria-labelledby="schooleditModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">School Edit Modal<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="schooleditform" method="POST" action="#" enctype="multipart/form-data">
            <div id="save_errors">

            </div>
        @csrf
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <input type="number" name="schoolid" id="schoolid" class="form-control" hidden>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">School Name</h6></label>
                    <input id="schooleditname" class="form-control" type="text" name="schooleditname" placeholder="Enter The School Name" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Level of the School</h6></label>
                    <select class="form-control mb-2" name="schooleditlevel" id="schooleditlevel">
                        <option value="">Select the level of the School</option>
                        <option value="PrimarySchool">Primary School</option>
                        <option value="SecondarySchool">Secondary School</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">County</h6></label>
                    <input id="editcounty" type="text" class="form-control" name="editcounty" placeholder="Enter the name of the County where the school is located" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Sub-county</h6></label>
                    <input id="editsubcounty" type="text" class="form-control" name="editsubcounty" placeholder="Enter The subcounty where the school is located" />  
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Motto</h6></label>
                    <input id="editmotto" type="text" class="form-control" name="editmotto" placeholder="School Motto" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">SMS KEY</h6></label>
                    <input id="editsmskey" type="text" class="form-control" name="editsmskey" placeholder="SMS KEY" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">SMS Shortcode</h6></label>
                    <input id="editsmsshortcode" type="text" class="form-control" name="editsmsshortcode" placeholder="SMS Short Code" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">School Account Number</h6></label>
                    <input id="editschoolaccountnumber" type="text" class="form-control" name="editschoolaccountnumber" placeholder="School Account" />
                </div>
            </div>

            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">School Email</h6></label>
                    <input id="editemail" class="form-control" type="email" name="editemail" placeholder="School Email" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Phone Number</h6></label>
                    <input id="editphone" class="form-control" type="tel" name="editprimaryphone" placeholder="Phone Number" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Alternative Phone Number</h6></label>
                    <input id="editaltphone" class="form-control" type="tel" name="editaltphone" placeholder="Alternative Phone Number" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">P.O BOX</h6></label>
                    <input id="editpobox" class="form-control" type="text" name="editpobox" placeholder="Enter PO-BOX" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">TOWN</h6></label>
                    <input id="edittown" class="form-control" type="text" name="edittown" placeholder="PO-BOX Town" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">MPESA CODE</h6></label>
                    <input id="editmpesacode" class="form-control" type="text" name="editmpesacode" placeholder="Pay Bill Number" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Type of MPESA code</h6></label>
                    <input id="edittype" class="form-control" type="text" name="edittype" placeholder="Type of MPESA code" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Daraja KEY</h6></label>
                    <input id="editdarajakey" class="form-control" type="text" name="editdarajakey" placeholder="Daraja KEY" />
                </div>
            </div>
        </div>

        <div class="form-group mb-2">
            <label><h6 class="text-danger">SMS Balance on Website</h6></label>
            <input id="editsmswebsitebalance" class="form-control" type="text" name="editsmswebsitebalance" placeholder="SMS Balance on Website" />
        </div>
        <div class="form-group mb-2">
            <label><h6 class="text-danger">School SMS API Balance</h6></label>
            <input id="editsmsapibalance" class="form-control" type="text" name="editsmsapibalance" placeholder="School SMS API Balance" />
        </div>
        <div class="form-group mb-2">                      
            <label><h6 class="text-danger">Select Your School Logo(Will appear in all sytem auto-generated files)</h6></label>
            <input class="form-control" id="editlogo" onchange="preview2()" type="file" name="editlogo"/>
        </div>                       
        
        <div class="logo-preview d-flex justify-content-center mb-2">
            <img src="" id="frame2" class="img-fluid" alt="LOGO">
        </div>
                                    
        <div class="form-group">
            <input type="submit" id="editschoolsubmitbtn" class="form-control btn-sm btn btn-info" value="EDIT SCHOOL">
        </div>
        </form>
        </div>
    </div>
    </div>
</div>
<!---School edit modal End--->

<!---School view modal start--->
<div class="modal w3-animate-zoom" id="schoolviewModal" tabindex="-1" aria-labelledby="schoolviewModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel"><span id="titleteacher" class="text-danger"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <h5 class="text-center text-success" id="nameofschool"></h5>
         <div class="text-center" id="schoolimg"></div>
         <hr>
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h6>Level : <span class="text-danger" id="level"></span></h6>
                    <h6>Motto : <span class="text-danger" id="motto"></span></h6>
                    <h6>Phone : <span class="text-danger" id="phone"></span></h6>
                    <h6>Alt Phone : <span class="text-danger" id="alt_phone"></span></h6>
                    <h6>County : <span class="text-danger" id="county"></span></h6>
                    <h6>Sub-County : <span class="text-danger" id="subcounty"></span></h6>
                    <h6>PO BOX : <span class="text-danger" id="pobox"></span>,<span id="town"></span></h6>
                    <h6>Paybill : <span class="text-danger" id="Paybill"></span></h6>
                    <h6>Type of MPESA code : <span class="text-danger" id="typeofcode"></span></h6>
                    <h6>Account Number : <span class="text-danger" id="schoolaccount"></span></h6>
                    <h6>Daraja_KEY : <span class="text-danger" id="Darajakey"></span></h6>
                    <h6>SMS Balance : <span class="text-danger" id="SMSbalance"></span></h6>
                    <h6>Website SMS Balance : <span class="text-danger" id="SMSbalanceonwebsite"></span></h6>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h5 class="text-center">Number of students <span class="text-info" id="stunumber"></span></h5>
                    <h5 class="text-center">Number of Staff Members <span class="text-info" id="staffnumber"></span></h5>
                    <hr>
                    <h6 class="text-center text-danger">Super Admin Details</h6>
                    <p>Name <b><span class="text-success" id="adminname"></span></b></p>
                    <p>UserName <b><span class="text-success" id="username"></span></b></p>
                    <p>Email <b><span class="text-success" id="adminemail"></span></b></p>
                    <p>Phone Number <b><span class="text-success" id="adminphone"></span></b></p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!---School view modal start--->

<!---Add School Admin Controller modal start--->
<div class="modal w3-animate-zoom" id="adminaddModal" tabindex="-1" aria-labelledby="adminaddModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Add Admin<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                    <form action="#" method="POST" id="admin-register">
                    <div class="row justify-content-center align-items-center">
                    <div class="col-lg-5 col-md-7 col-sm-10">
                            <div id="show_success_alert"></div>
                            @csrf
                            <div class="mb-3 d-none">
                                <input class="form-control" type="text" name="school" id="school" placeholder="Enter School">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="salutation" placeholder="Enter Salutation" id="salutation">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="fname" placeholder="Enter First Name" id="fname">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="lname" placeholder="Enter Last Name" id="lname">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="radio" name="gender" value="Male" id="gender">&nbsp; Male
                                <input type="radio" name="gender" value="Female" id="gender">&nbsp; Female
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="email" name="email" placeholder="Enter Email" id="email">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <input class="form-control" type="tel" name="phone" placeholder="Enter Phone" id="phone">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3 d-grid">
                                <input type="submit" value="REGISTER" class="btn btn-success rounded-0" id="register_btn">
                            </div>
                            <div class="text-center text-secondary">

                            </div>
                            </div>
                            </div>
                    </form>
    </div>
    </div>
    </div>
    </div>
</div>
<!---Add School Admin Controller modal end--->

<!--Add School modal start--->
<div id="schooladdModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">Add School Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="msform" method="POST" action="#" enctype="multipart/form-data">
      @csrf
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">School Name</h6></label>
                    <input id="schoolname" class="form-control" type="text" name="schoolname" placeholder="Enter The School Name" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Level of the School</h6></label>
                    <select class="form-control mb-2" name="schoollevel" id="schoollevel">
                        <option value="">Select the level of the School</option>
                        <option value="PrimarySchool">Primary School</option>
                        <option value="SecondarySchool">Secondary School</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">County</h6></label>
                    <input id="county" type="text" class="form-control" name="county" placeholder="Enter the name of the County where the school is located" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Sub-county</h6></label>
                    <input id="subcounty" type="text" class="form-control" name="subcounty" placeholder="Enter The subcounty where the school is located" />  
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Motto</h6></label>
                    <input id="motto" type="text" class="form-control" name="motto" placeholder="School Motto" />
                </div>
            </div>

            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">School Email</h6></label>
                    <input id="email" class="form-control" type="email" name="semail" placeholder="School Email" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Phone Number</h6></label>
                    <input id="phone" class="form-control" type="tel" name="primaryphone" placeholder="Phone Number" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">Alternative Phone Number</h6></label>
                    <input id="altphone" class="form-control" type="tel" name="altphone" placeholder="Alternative Phone Number" /> 
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">P.O BOX</h6></label>
                    <input id="pobox" class="form-control" type="text" name="pobox" placeholder="Enter PO-BOX" />
                </div>
                <div class="form-group mb-2">
                    <label><h6 class="text-danger">TOWN</h6></label>
                    <input id="town" class="form-control" type="text" name="town" placeholder="PO-BOX Town" />
                </div>
            </div>
        </div>

        <div class="form-group mb-2">                      
            <label><h6 class="text-danger">Select Your School Logo(Will appear in all sytem auto-generated files)</h6></label>
            <input class="form-control" id="logo" onchange="preview()" type="file" name="logo"/>
        </div>                       
        
        <div class="logo-preview d-flex justify-content-center mb-2">
            <img src="" id="frame" class="img-fluid" alt="LOGO">
        </div>
                                    
        <div class="form-group">
            <input type="submit" id="submitbtn" class="form-control btn-sm btn btn-info" value="REGISTER SCHOOL">
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Add School modal end--->

<div class="container">
<h5 class="text-danger">Schools</h5>
<div class="mb-2">
<button class="btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#schooladdModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;ADD SCHOOL</button>
</div>   

    <div class="d-flex row justify-content-center align-items-center">
        <div id="response"></div>
        <div class="col-lg-8 col-md-10 col-sm-12">

        <div id="actionbtns" class="mb-2">
        <button id="addalertbtn" type="button" class="btn btn-sm btn-success float-end">Add Alert</button>
        <button id="removealertbtn" type="button" class="btn btn-sm btn-warning float-end">Remove Alert</button>
        <button id="viewbtn" class="btn btn-sm btn-info float-end"><i class="fas fa-eye"></i>&nbsp;View</button>
        <button id="addadminbtn" class="btn btn-sm btn-success float-end">Add Admin</button>
        <button id="deativateschoolbtn" class="btn btn-sm btn-info float-end">Deactivate</button>
        <button id="activateschoolbtn" class="btn btn-sm btn-success float-end">Activate</button>
        <button id="schooleditbtn" type="button" class="btn btn-sm btn-warning float-end"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
        <button id="schooldeletebtn" class="btn btn-sm btn-danger float-end"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button> 
        </div>

            <div class="table-responsive">
                <table class="table" id="tableforschools">
                <thead>
                <tr>
                    <th scope="col"><input type="checkbox" id="CheckAll"></th>
                    <th scope="col">Logo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Level</th>
                    <th scope="col">Motto</th>
                    <th scope="col">County</th>
                    <th scope="col">Alert</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody id="schoolstable">
                    
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function preview(){
        frame.src=URL.createObjectURL(event.target.files[0]);
    }

    function preview2(){
        frame2.src=URL.createObjectURL(event.target.files[0]);
    }
</script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/fontjs/all.min.js') }}"></script>
<script>
    $(document).ready(function(){
        fetchschools();

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        //Function to fetch Schools
        function fetchschools(){
            $.ajax({
                method: 'GET',
                url: `/fetchschools`,
                //dataType: 'jsons',
                success: function(res) {
                $('#schoolstable').html('');
                  $.each(res.schools,function(key,item){

                    var html = '';
                    html += '<tr class="'+(item.Active == 0 ? "" : "w3-red")+'">';
                    html += '<td><input id="schoolcheckbox" type="checkbox" value="'+item.id+'" name="id[]"></td>';
                    html += '<td><img  width="50" height="50" class="img-fluid" src="images/'+item.logo+'" alt=""></td>';
                    html += '<td>'+item.name+'</td>';
                    html += '<td>'+item.id+'</td>';
                    html += '<td>'+item.level+'</td>';
                    html += '<td>'+item.motto+'</td>';
                    html += '<td>'+item.county+'</td>';
                    html += '<td>'+item.Alert+'</td>';

                    if (item.Active == 0) {
                        html += '<td>Active</td>';
                    } else {
                        html += '<td>Deactivated</td>';
                    }
                    html += '</tr>';

                    $('#schoolstable').append(html); 
                  })

                  $("#tableforschools").DataTable().fnDestroy()

                    $('#tableforschools').DataTable({
                    ordering: false,
                    paging: true,
                    searching: true
                        });
                }
            })
        }

    //School Reg Form Submission
    $('#msform').submit(function(e){
    e.preventDefault();
    $('#submitbtn').val('PLEASE WAIT...');
    var formData = new FormData($('#msform')[0]);

            $.ajax({
               url: '{{ route('school.register') }}',
               method: 'POST',
               contentType: false,
               processData: false,
               data: formData,
               dataType: 'json',
               success: function(res){
                    if(res.status == 400){
                        $('#submitbtn').val('REGISTER SCHOOL');
                        $('#save_errorlist').html('');
                        $('#save_errorlist').removeClass('d-none');
                        $.each(res.errors, function(key,value){
                            $('#save_errorlist').append('<li>'+value+'</li>');
                        })
                    } else if(res.status == 200){
                        $("#schooladdModal").modal('hide');
                        fetchschools();
                        $('#submitbtn').val('REGISTER SCHOOL');
                        $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>School Registered Successfully</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        //window.location = '{{ route('adminregister') }}'
                    }
               }
           }) 
        }) 

    //School Edit Form Submission
    $('#schooleditform').submit(function(e){
    e.preventDefault();
    $('#editschoolsubmitbtn').val('PLEASE WAIT...');
    var formData = new FormData($('#schooleditform')[0]);

            $.ajax({
               url: '/editschool',
               method: 'POST',
               contentType: false,
               processData: false,
               data: formData,
               dataType: 'json',
               success: function(res){
                //console.log(res);
                    $('#editschoolsubmitbtn').val('EDIT SCHOOL');
                    if(res.status == 400){
                        //$('#editschoolsubmitbtn').val('EDIT SCHOOL');
                        $('#save_errors').html('');
                        $('#save_errors').removeClass('d-none');
                        $.each(res.errors, function(key,value){
                            $('#save_errors').append('<li>'+value+'</li>');
                        })
                    } else if(res.status == 200){
                        $("#schooleditModal").modal('hide');
                        fetchschools();
                        //$('#editschoolsubmitbtn').val('EDIT SCHOOL');
                        $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>School Details Updated Successfully</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        //window.location = '{{ route('adminregister') }}'
                    }
               }
           }) 
        })
        
    //School Add Alert Form Submission
    $('#schooladdalertform').submit(function(e){
    e.preventDefault();
    $('#alertsubmitbtn').val('PLEASE WAIT...');
    var formData = new FormData($('#schooladdalertform')[0]);

            $.ajax({
               url: '/addalert',
               method: 'POST',
               contentType: false,
               processData: false,
               data: formData,
               dataType: 'json',
               success: function(res){
                //console.log(res);
                    $('#alertsubmitbtn').val('SUBMIT ALERT');
                    if(res.status == 400){
                        
                    } else if(res.status == 200){
                        $("#schooladdAlertModal").modal('hide');
                        fetchschools();
                        $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
               }
           }) 
        }) 

    //Add Admin modal
    $(document).on('click', '#addadminbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#schoolcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a School to add Admin');
        } else if(ids.length > 1){
            alert('You can only add admin for one school at a time');
        } else {
           $("#school").val(ids);
           $('#adminaddModal').modal('show'); 
        }
     })

    //School Viewing
    $(document).on('click', '#viewbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#schoolcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a School to view details');
        } else if(ids.length > 1){
            alert('You can only view details of one School at a Time.Select only one School');
        } else {
           fetchschool(ids)
           $('#schoolviewModal').modal('show'); 
        }
     })

    //Add Alert btn            
    $(document).on('click', '#addalertbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#schoolcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a School to add Alert');
        } else {
           //fetchschool(ids)
           $("#alertschools").val(ids);
           $('#schooladdAlertModal').modal('show'); 
        }
     })

    //Add Alert btn            
    $(document).on('click', '#removealertbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#schoolcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a School to Delete Alert');
        } else {
            var confirm = window.confirm(`Are you sure you want to Delete Alert for this School?`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/removeschoolalert/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res);
                   if (res.status == 200) {
                    fetchschools();
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>"Sorry! Something went wrong. Please try agin Later."</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            } 
        }
     })

    //School Edit Modal
    $(document).on('click', '#schooleditbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#schoolcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a School to edit');
        } else if(ids.length > 1){
            alert('You can only edit one School at a time. Select only one School');
        } else {
            fetchschool2(ids);
           $('#schooleditModal').modal('show'); 
        }
     })

    //School Deactivate ajax
    $(document).on('click', '#deativateschoolbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#schoolcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select school(s) to deactivate')
        } else {
            var confirm = window.confirm(`Are you sure you want to Deactivate this School?`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deactivateschool/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchschools();
                    //$('#booksregres').removeClass('d-none');
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    //$('#booksregres').removeClass('d-none');
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>"Sorry! Something went wrong. Please try agin Later."</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
        }
     })

    //School Deactivate ajax
    $(document).on('click', '#activateschoolbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#schoolcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select school(s) to activate')
        } else {
            var confirm = window.confirm(`Are you sure you want to activate this School?`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/activateschool/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchschools();
                    //$('#booksregres').removeClass('d-none');
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    //$('#booksregres').removeClass('d-none');
                    $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>"Sorry! Something went wrong. Please try agin Later."</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
        }
     })

    //Submit Admin form
    $("#admin-register").submit(function(e){
           e.preventDefault();
           removeValidationClasses('#admin-register');
           $('#register_btn').val('Please wait...');
           $.ajax({
               url: '{{ route('admin.register') }}',
               method: 'post',
               data: $(this).serialize(),
               dataType: 'json',
               success: function(res){
                    if(res.status == 400){
                        showError('salutation', res.messages.salutation);
                        showError('fname', res.messages.fname);
                        showError('lname', res.messages.lname);
                        showError('gender', res.messages.gender);
                        showError('school', res.messages.school);
                        showError('email', res.messages.email);
                        showError('phone', res.messages.phone);
                        showError('password', res.messages.password);
                        showError('cpassword', res.messages.cpassword);
                        $('#register_btn').val('REGISTER');
                    } else if(res.status == 200){
                        $('#show_success_alert').html(showMessage('success', res.messages));
                        $('#admin-register')[0].reset();
                        removeValidationClasses('#admin-register');
                        $('#register_btn').val('REGISTER');
                        $("#adminaddModal").modal('hide');
                        $('#response').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
               }
           }) 
       })

    //Function to fetch School for viewing
    function fetchschool(id){
            $.ajax({
                method: 'GET',
                url: `/getschool/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.school;
                    $("#nameofschool").text(data.name);
                    $("#schoolimg").html('<img src="images/'+data.logo+'" class="img-fluid"/>');
                    $("#level").text(data.level);
                    $("#motto").text(data.motto);
                    $("#county").text(data.county);
                    $("#subcounty").text(data.subcounty);
                    $("#phone").text(data.phone);
                    $("#alt_phone").text(data.alt_phone);
                    $("#pobox").text(data.pobox);
                    $("#town").text(data.town);
                    $("#Paybill").text(data.Mpesa_code);
                    $("#typeofcode").text(data.typeofmpesacode);
                    $("#schoolaccount").text(data.schoolaccountnumber);
                    $("#Darajakey").text(data.Darajakey);
                    $("#SMSbalance").text(data.SMSbalance);
                    $("#SMSbalanceonwebsite").text(data.SMSbalanceonwebsite);
                    //$("#").text(data.);
                    $("#stunumber").text(res.students);
                    $("#staffnumber").text(res.staff);

                    if (res.superadmin.length == 0) {
                        $("#adminname").text('N/A');
                        $("#adminphone").text('N/A');
                        $("#adminemail").text('N/A');
                    } else {
                        $("#adminname").text(res.superadmin[0].Salutation+' '+res.superadmin[0].Fname+' '+res.superadmin[0].Lname);
                        $("#adminphone").text(res.superadmin[0].Phone);
                        $("#adminemail").text(res.superadmin[0].Email); 
                        $("#username").text(res.superadmin[0].username);
                    }
                }                   
                })
        }

    //Function to fetch School for viewing
    function fetchschool2(id){
            $.ajax({
                method: 'GET',
                url: `/getschool/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.school;
                    //console.log(data);
                    $("#schoolid").val(data.id);
                    $("#frame2").attr('src', 'images/'+data.logo+'');
                    $("#schooleditname").val(data.name);
                    //$("#schoolimg").html('<img src="images/'+data.logo+'" class="img-fluid"/>');
                     $("#editemail").val(data.email);
                     $("#editmotto").val(data.motto);
                     $("#editcounty").val(data.county);
                     $("#editsubcounty").val(data.subcounty);
                     $("#editphone").val(data.phone);
                     $("#editaltphone").val(data.alt_phone);
                     $("#editpobox").val(data.pobox);
                     $("#edittown").val(data.town);
                     $("#editsmskey").val(data.SMS_KEY);
                     $("#editdarajakey").val(data.Darajakey);
                     $("#editsmswebsitebalance").val(data.SMSbalanceonwebsite);
                     $("#editsmsapibalance").val(data.SMSbalance);
                     $("#editmpesacode").val(data.Mpesa_code);
                     $("#editschoolaccountnumber").val(data.schoolaccountnumber);
                     $("#edittype").val(data.typeofmpesacode);
                     $("#editsmsshortcode").val(data.Shortcode);
                    //  $("#editsmswebsitebalance").val(data.SMSbalanceonwebsite);
                    //  $("#editsmsapibalance").val(data.SMSbalance);
                }                   
                })
        }
    
    })
</script>
<script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/62ac7eac7b967b1179950f47/1g5ostl3n';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
</script>
</body>
</html>