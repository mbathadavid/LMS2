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
                        <h5 class="text-center text-info">Reset Password</h5>
                    </div>
                    <div class="card-body">
                            <form action="#" method="POST" id="resetpass-form">
                            @csrf
                            <div class="mb-3">
                                Enter your Email here and we will send you an Email verification link there
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="email" name="email" placeholder="Enter Your Email" id="email">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3 d-grid">
                                <input type="submit" value="RESET PASSWORD" class="btn btn-success rounded-0" id="passreset_btn">
                            </div>
                            <div class="text-center text-secondary">
                                Don't have account? <a href="/adminregister" class="text-decoration-none text-info">Register here</a>
                            </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>   
</body>
</html>