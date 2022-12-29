
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Parent Login</title>
<body class="bg-dark">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center text-info">Parent Login</h5>
                    </div>
                    <div class="card-body">
                            <form action="#" method="POST" id="parent-login">
                                <div id="login_alert">

                                </div>
                            @csrf
                            <div class="mb-3">
                                <select name="school" class="form-control" id="school">
                                    <option value="">Select your School</option>
                                    @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}, {{ $school->county }} county</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="emailorphone" placeholder="Enter your Phone Number" id="emailorphone">
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="mb-3">
                                <input class="form-control" type="password" name="password" placeholder="Enter Password" id="password">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <a class="text-decoration-none text-danger" href="/parentresetpass">Forgot password?</a>
                            </div>

                            <div class="mb-3 d-grid">
                                <input type="submit" value="LOGIN" class="btn btn-success rounded-0" id="login_btn">
                            </div>
                            <div class="text-center text-secondary">
                                <!-- Don't have account? <a href="/adminregister" class="text-decoration-none text-info">Register here</a> -->
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
    $(function(){
        $('#parent-login').submit(function(e){
            $('#login_btn').val('Please Wait...');
            removeValidationClasses($("#parent-login"))
            e.preventDefault();
            $.ajax({
                url: '{{ route('parent.login') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    if (res.status == 400) {
                        showError('school',res.messages.school);
                        showError('emailorphone',res.messages.emailorphone);
                        showError('password',res.messages.password);
                        $('#login_btn').val('LOGIN');
                    } else if(res.status == 401){
                        $('#login_alert').html(showMessage('danger',res.messages));
                        $('#login_btn').val('LOGIN');
                    } else if(res.status == 200 && res.messages == 'success'){
                        $('#login_btn').val('LOGIN');
                        window.location = '{{ route('parentdashboard') }}'
                    }
                }
            })
        })
    })
</script>  
</body>
</html>