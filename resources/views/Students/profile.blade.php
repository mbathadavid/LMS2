@extends('layouts.layout')

@section('title','Profile')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Students.sidebar')
</div>
<div id="main" class="maincontent">
@include('Students.topnav')

<!---Edit Account Details Start--->
<div class="modal w3-animate-zoom modal-md" id="editaccountModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Edit Profile Details<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="editaccountform" class="p-2" method="POST" enctype="multipart/form-data">
         <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <input type="number" name="uid" id="uid" value="{{ session()->get('LoggedInUser.id') }}" hidden>

             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">First Name</h6></label>
                <input type="text" name="fname" id="fname" value="{{ session()->get('LoggedInUser.Fname') }}" class="form-control">
                <div class="invalid-feedback"></div>
             </div>

             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Last Name</h6></label>
                <input type="text" name="lname" id="lname" value="{{ session()->get('LoggedInUser.Lname') }}" class="form-control">
                <div class="invalid-feedback"></div>
             </div>

             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Gender</h6></label>
                <input type="text" name="gender" id="gender" value="{{ session()->get('LoggedInUser.Gender') }}" class="form-control">
                <div class="invalid-feedback"></div>
             </div>
            </div> 
            
            <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Email</h6></label>
                <input type="text" name="email" id="email" value="{{ session()->get('LoggedInUser.Email') }}" class="form-control">
                <div class="invalid-feedback"></div>
             </div>

             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Phone</h6></label>
                <input type="text" name="phone" id="phone" value="{{ session()->get('LoggedInUser.Phone') }}" class="form-control">
                <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Alternative Phone</h6></label>
                <input type="text" name="altphone" id="altphone" value="{{ session()->get('LoggedInUser.AltPhone') }}" class="form-control">
                <div class="invalid-feedback"></div>
             </div>
            </div>
            
         
            <div class="form-group mb-2 d-grid">
             <input type="submit" id="editaccountbtn" class="btn btn-success btn-sm rounded-0" value="UPDATE ACCOUNT DETAILS">
            </div>

         </div>
        </form>
    </div>
    </div>
    </div>
    </div>
<!---Edit Account modal End--->


<!---Edit Account Password Start--->
<div class="modal w3-animate-zoom modal-md" id="editaccountpasswordModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Change Password<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="editpasswordform" class="p-2" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
         <input type="number" name="uid" id="uid" value="{{ session()->get('LoggedInUser.id') }}" hidden>
            <div class="form-group mb-2">
                <label for=""><h6 class="text-danger">Enter Current Password</h6></label>
                <input type="password" name="cpass" id="cpass" placeholder="Your Current Password" class="form-control">
                <div class="invalid-feedback"></div>
             </div>

             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Enter New Password</h6></label>
                <input type="password" name="npass" id="npass" placeholder="Your New Password" class="form-control">
                <div class="invalid-feedback"></div>
             </div>

             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Confirm New Password</h6></label>
                <input type="password" name="cnpass" id="cnpass" placeholder="Confirm New Password" class="form-control">
                <div class="invalid-feedback"></div>
             </div>

             <input type="submit" id="changepass" value="CHANGE PASSWORD" class="btn btn-info rounded-0 btn-sm form-control">
         </div>
         </div>

        </form>
    </div>
    </div>
    </div>
    </div>
<!---Edit Account Password End--->


<!---Edit Account Details Start--->
<div class="modal w3-animate-zoom modal-md" id="updateprofileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Update Profile<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="updateprofileform" class="p-2" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
         <input type="number" name="uid" id="uid" value="{{ session()->get('LoggedInUser.id') }}" hidden>

         <div class="card" style="height: auto;">
            <div class="card-body">
                <img id="chosenprof" src="images/{{ session()->get('LoggedInUser.profile') }}" class="card-img-top img-fluid" alt="">
            </div>
            </div>

            <div class="form-group mt-2">
            <input class="form-control" onchange="preview()" type="file" name="profilepic" id="profilepic"/>
            <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mt-2">
                <input type="submit" class="btn btn-sm btn-success rounded-0 form-control" id="submitprofupdate" value="UPDATE PROFILE">
            </div>
         </div>
         </div>
        </form>
    </div>
    </div>
    </div>
    </div>
<!---Edit Account modal End--->


<div class="row justify-content-center align-item-center">
    <div id="accountupdatedivres">
        
    </div>
<div class="col-lg-7 col-md-7 col-sm-12">
<h5 class="text-center">MY ACCOUNT DETAILS</h5>
<div class="p-2 m-2" style="background-color: #b3b3b3;">
    <h5 class="text-center">First Name : <b class="text-danger">{{ session()->get('LoggedInUser.Fname') }}</b></h5>
    <h5 class="text-center">Last Name : <b class="text-danger">{{ session()->get('LoggedInUser.Lname') }}</b></h5>
    <h5 class="text-center">Admission No : <b class="text-danger">{{ session()->get('LoggedInUser.AdmissionNo') }}</b></h5>
    <h5 class="text-center">UPI No : <b class="text-danger">{{ session()->get('LoggedInUser.UPI') }}</b></h5>
    <h5 class="text-center">Username : <b class="text-danger">{{ session()->get('LoggedInUser.StudentId') }}</b></h5>
    <h5 class="text-center">School System : <b class="text-danger">{{ session()->get('LoggedInUser.schoolsystem') }}</b></h5>
    <h5 class="text-center">Class : <b class="text-danger">{{ session()->get('LoggedInUser.current_class') }}</b></h5>
    <h5 class="text-center">Gender : <b class="text-danger">{{ session()->get('LoggedInUser.gender') }}</b></h5>
    
</div>
<div style="text-align: center;">
<!-- <button type="button" class="btn btn-success btn-sm" id="showprofileeditmodal">
    <i class="fas fa-edit"></i>&nbsp; Edit Account Details
</button> -->
<button type="button" class="btn btn-danger btn-sm" id="showpasswordchangemodal">
    <i class="fas fa-key"></i>&nbsp; Change Password
</button>
</div>
</div>

<div class="col-lg-5 col-md-5 col-sm-12">
<div class="card" style="height: auto;">
  <div class="card-header">
    <p class="text-center">{{ session()->get('LoggedInUser.Salutation') }} {{ session()->get('LoggedInUser.Fname') }} {{ session()->get('LoggedInUser.Lname') }}</p>
  </div>

  <div class="card-body">
    <img src="images/{{ session()->get('LoggedInUser.profile') }}" class="card-img-top img-fluid" alt="">
  </div>

  <div class="card-footer text-center">
    <button class="btn btn-info btn-sm" id="showprofilechangemodal">
        <i class="fas fa-user"></i>&nbsp; Update Profile Picture
    </button>
  </div>

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
function preview(){
    chosenprof.src=URL.createObjectURL(event.target.files[0]);
}
</script>

<script>
$(document).ready(function(){
    //set csrf
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });


    $('#showprofileeditmodal').click(function(e){
        e.preventDefault();
        $('#editaccountModal').modal('show'); 
    })

    $('#showpasswordchangemodal').click(function(e){
        e.preventDefault();
        $('#editaccountpasswordModal').modal('show'); 
    })

    $('#showprofilechangemodal').click(function(e){
        e.preventDefault();
        $('#updateprofileModal').modal('show'); 
    })

    //Submit Profile Update
    $("#updateprofileform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($("#updateprofileform"))
            $('#submitprofupdate').val('PLEASE WAIT...');
            var formData = new FormData($('#updateprofileform')[0]);

            $.ajax({
                method: 'POST',
                url: '{{ route('student.updatepic') }}',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                //console.log(res);
                $('#submitprofupdate').val('UPDATE PROFILE');
                   if (res.status == 401) {
                    showError('profilepic', res.messages);
                   } else if(res.status == 200){
                    $('#accountupdatedivres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    removeValidationClasses($("#updateprofileform"));
                    $('#updateprofileModal').modal('hide');
                    
                   } else if(res.status == 400) {
                     showError('profilepic', res.messages.profilepic);
                   }  
               }
            })
        })
        //Update Account Details
        $("#editaccountform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($("#editaccountform"))
            $('#editaccountbtn').val('PLEASE WAIT...');
            var formData = new FormData($('#editaccountform')[0]);

            $.ajax({
                method: 'POST',
                url: '{{ route('parent.accountdeatails') }}',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                console.log(res);
                $('#editaccountbtn').val('UPDATE ACCOUNT DETAILS');
                   if (res.status == 400) {
                    showError('editsalutation', res.messages.editsalutation);
                    showError('fname', res.messages.fname);
                    showError('lname', res.messages.lname);
                    showError('gender', res.messages.gender);
                    showError('email', res.messages.email);
                    showError('phone', res.messages.phone);
                   } else if(res.status == 200){
                    $('#accountupdatedivres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    removeValidationClasses($("#editaccountform"));
                    $('#editaccountModal').modal('hide');
                   } 
               }
            })
        })

        //Change Password Form Submit
        $("#editpasswordform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($("#editpasswordform"))
            $('#changepass').val('PLEASE WAIT...');
            var formData = new FormData($('#editpasswordform')[0]);
            if ($("#npass").val() !== $("#cnpass").val()) {
                alert("The Passwords do not Match. Please make Sure New Password and Confirm New Password Fields Match");
            } else {
            $.ajax({
                method: 'POST',
                url: '{{ route('student.updatepassword') }}',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                //console.log(res);
                $('#changepass').val('CHANGE PASSWORD');
                   if (res.status == 400) {
                    showError('cpass', res.messages.cpass);
                    showError('npass', res.messages.npass);
                    showError('cnpass', res.messages.cnpass);
                   } else if(res.status == 200){
                    $('#accountupdatedivres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                    removeValidationClasses($("#editpasswordform"));
                    $('#editaccountpasswordModal').modal('hide');
                   } else if(res.status == 401) {
                    showError('cpass', res.messages);  
                   } 
               }
            })
        }
        })
    
})
</script>
@endsection