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
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')

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
            <input type="number" name="uid" value="{{ session()->get('LoggedInUser.id') }}" hidden>
            <div class="form-group mb-2">
            <label for=""><h6 class="text-success">Salutation</h6></label>
                <select name="editsalutation" id="editsalutation" class="form-control">
                    <option value="{{ session()->get('LoggedInUser.Salutation') }}">{{ session()->get('LoggedInUser.Salutation') }}</option>
                    <option value="Ms">Miss</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Madam">Madam</option>
                </select>
                <div class="invalid-feedback"></div>
             </div>

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
                <label for=""><h6 class="text-success">Role</h6></label>
                <input type="text" name="role" id="role" value="{{ session()->get('LoggedInUser.Role') }}" class="form-control" readonly>
                <div class="invalid-feedback"></div>
             </div>
            </div>
            @if(session()->get('LoggedInUser.Role') == 'Super Admin')
            <div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Your have all the System Priviledges</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
            @else
            <div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Your Priviledges can only be updated by the school super Admin</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
            @endif
            
         
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
         <input type="number" name="uid" value="{{ session()->get('LoggedInUser.id') }}" hidden>
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
         <input type="number" name="uid" value="{{ session()->get('LoggedInUser.id') }}" hidden>

         <div class="card" style="height: auto;">
            <div class="card-body">
                <img id="chosenprof" src="images/{{ session()->get('LoggedInUser.Profile') }}" class="card-img-top img-fluid" alt="">
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
    <h5 class="text-center">Salutation : <b class="text-danger">{{ session()->get('LoggedInUser.Salutation') }}</b></h5>
    <h5 class="text-center">First Name : <b class="text-danger">{{ session()->get('LoggedInUser.Fname') }}</b></h5>
    <h5 class="text-center">Last Name : <b class="text-danger">{{ session()->get('LoggedInUser.Lname') }}</b></h5>
    <h5 class="text-center">Email : <b class="text-danger">{{ session()->get('LoggedInUser.Email') }}</b></h5>
    <h5 class="text-center">Phone : <b class="text-danger">{{ session()->get('LoggedInUser.Phone') }}</b></h5>
    <h5 class="text-center">Role : <b class="text-danger">{{ session()->get('LoggedInUser.Role') }}</b></h5>
    <div class="" style="background-color: #e6e6e6;">
        <h4 class="text-center text-success">System Priviledges</h4>
        @if(session()->get('LoggedInUser.Role') == 'Super Admin')
        <h6 class="text-center">You have all the system priviledges</h6>
        @else
        @if(session()->get('LoggedInUser.priviledges') == null)
            <h6 class="text-center">No Priviledges Assigned Yet</h6>
        @else
            @for($i=0; $i < count(explode(',',session()->get('LoggedInUser.priviledges'))); $i++)
                <p class="text-center">{{ explode(',',session()->get('LoggedInUser.priviledges'))[$i] }}</p>
            @endfor
        @endif
        @endif
    </div>
</div>
<div style="text-align: center;">
<button type="button" class="btn btn-success btn-sm" id="showprofileeditmodal">
    <i class="fas fa-edit"></i>&nbsp; Edit Account Details
</button>
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
    <img src="images/{{ session()->get('LoggedInUser.Profile') }}" class="card-img-top img-fluid" alt="">
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
                url: '/updateteacherprofilepic',
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
                url: '/updateteacheraccountDetails',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
                success: function(res){
                //console.log(res);
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
                url: '/updatestaffpassword',
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