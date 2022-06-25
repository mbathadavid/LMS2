<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center text-info">Admin Register</h5>
                    </div>
                    <div class="card-body">
                            <form action="#" method="POST" id="admin-register">
                            <div id="show_success_alert"></div>
                            @csrf
                            <div class="mb-3">
                                <select name="school" id="school" class="form-control">
                                 <option value="">Select the School of the Admin</option>
                                @foreach($schools as $school)
                                  <option value="{{ $school->id }}">{{ $school->name }}, {{ $school->county }} county</option>
                                @endforeach
                                </select>
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
                            
                            <!-- <div class="mb-3">
                                <input class="form-control" type="password" name="password" placeholder="Enter Password" id="password">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <input class="form-control" type="password" name="cpassword" placeholder="Confirm Password" id="cpassword">
                                <div class="invalid-feedback"></div>
                            </div> -->

                            <div class="mb-3 d-grid">
                                <input type="submit" value="REGISTER" class="btn btn-success rounded-0" id="register_btn">
                            </div>
                            <div class="text-center text-secondary">
                                <!-- Already have account? <a href="/adminlogin" class="text-decoration-none text-info">Login here</a> -->
                            </div>
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
    $(function() {
       $("#admin-register").submit(function(e){
           e.preventDefault();
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
                    }
               }
           }) 
       }) 
    });
</script>
</body>
</html>