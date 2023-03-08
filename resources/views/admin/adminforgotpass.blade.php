<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Reset Password</title>
</head>
<body class="bg-dark">
<!---Edit Account Password Start--->
<div class="modal w3-animate-zoom modal-md" id="editaccountpasswordModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Reset Password<h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" id="resetpasswordform" class="p-2" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
         <input type="text" id="uid" name="uid" hidden>
         <div class="form-group mb-2">
            <label for=""><h6 class="text-success">Username</h6></label>
            <input type="text" name="username" id="username" class="form-control" readonly> 
         </div>
         
             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Enter New Password</h6></label>
                <input type="password" name="npass" id="npass" placeholder="Your New Password" class="form-control" required>
                <div class="invalid-feedback"></div>
             </div>

             <div class="form-group mb-2">
                <label for=""><h6 class="text-success">Confirm New Password</h6></label>
                <input type="password" name="cnpass" id="cnpass" placeholder="Confirm New Password" class="form-control" required>
                <div class="invalid-feedback"></div>
             </div>

             <input type="submit" id="setnewpass" value="SET NEW PASSWORD" class="btn btn-info rounded-0 btn-sm form-control">
         </div>
         </div>

        </form>
    </div>
    </div>
    </div>
    </div>
<!---Edit Account Password End--->


    <div class="container">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-6 col-md-7 col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center text-info">Reset Password</h5>
                    </div>
                    <div class="card-body">
                            <form action="#" method="POST" id="resetpass-form">
                            <div id="passresetdiv">

                            </div>

                            @csrf
                            <!-- <div class="mb-3">
                                Enter your Email here and we will send you an Email verification link there
                            </div> -->
                            <div class="mb-3">
                                <label for=""><h6 class="text-danger">Enter your registered phone number</h6></label>
                                <input class="form-control" type="phone" name="phoneno" placeholder="Enter Your Phone Number" id="phoneno">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3 d-grid">
                                <input type="submit" value="RESET PASSWORD" class="btn btn-success rounded-0" id="passreset_btn">
                            </div>
                            <!-- <div class="text-center text-secondary">
                                Don't have account? <a href="/adminregister" class="text-decoration-none text-info">Register here</a>
                            </div> -->
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script> 
<script>
    $(function(){
        //Submit reset form
        $('#resetpass-form').submit(function(e){
            $('#passreset_btn').val('Please Wait...');
            removeValidationClasses($("#resetpass-form"));

            e.preventDefault();
            $.ajax({
                url: '/adminresetpassword',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                   // console.log(res);

                    $('#passreset_btn').val('RESET PASSWORD');

                    if (res.status == 400) {
                        showError('phoneno',res.messages.phoneno);
                    } else if(res.status == 401){
                       $("#passresetdiv").html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else if(res.status == 200){
                        $("#uid").val(res.id);
                        $("#username").val(res.username);
                        $("#editaccountpasswordModal").modal('show');
                    }
                }
            })
        })

        //Submit newly reset password
        $('#resetpasswordform').submit(function(e){
            $('#setnewpass').val('Please Wait...');
            removeValidationClasses($("#resetpasswordform"));

            e.preventDefault();

            var pass = $("#npass").val();
            var npass = $("#cnpass").val();

            if (pass !== npass) {
                alert("Sorry! Make sure New Password and Confirm New Password Fields have the same values.");
            } else {
                $.ajax({
                url: '/adminsetnewpass',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    //console.log(res);
                    $('#setnewpass').val('RESET PASSWORD');
                    $("#editaccountpasswordModal").modal('hide');
                    $("#passresetdiv").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><p>You have successfully reset your password. Your new password is <b>'+res.password+'</b> and username is <b>'+res.username+'. Click to <a href="/adminlogin">LOG IN</a></b></p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                }
            })  
            } 
        })

    })
</script>   
</body>
</html>