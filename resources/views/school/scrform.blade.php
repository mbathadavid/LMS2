<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scf.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="container-fluid">

<form action="#" class="form" id="forms" onsubmit="event.preventDefault()">
    <div class="progressbar">
        <div class="progress" id="progress"></div>
        <div class="progress-step progress-step-active" data-title="Account"></div>
        <div class="progress-step" data-title="Social"></div>
        <div class="progress-step" data-title="Personal"></div>
    </div>
    <div class="step-forms step-forms-active">
        <div class="group-inputs"> <label for="username">Username</label> <input type="text" name="username" id="username" /> </div>
        <div class="group-inputs"> <label for="position">Email</label> <input type="text" name="position" id="position" /> </div>
        <div class="group-inputs"> <label for="email">Password</label> <input type="text" name="email" id="email" /> </div>
        <div class="group-inputs"> <label for="email">Confirm password</label> <input type="text" name="email" id="email" /> </div>
        <div class=""> <a href="#" class="btn btn-next width-50 ml-auto">Next</a> </div>
    </div>
    <div class="step-forms">
        <div class="group-inputs"> <label for="phone">Facebook</label> <input type="text" name="phone" id="phone" /> </div>
        <div class="group-inputs"> <label for="email">Twitter</label> <input type="text" name="email" id="email" /> </div>
        <div class="group-inputs"> <label for="email">Linkedin</label> <input type="text" name="email" id="email" /> </div>
        <div class="group-inputs"> <label for="email">Dribbble</label> <input type="text" name="email" id="email" /> </div>
        <div class="btns-group"> <a href="#" class="btn btn-prev">Previous</a> <a href="#" class="btn btn-next">Next</a> </div>
    </div>
    <div class="step-forms">
        <div class="group-inputs"> <label for="dob">Date of Birth</label> <input type="date" name="dob" id="dob" /> </div>
        <div class="group-inputs"> <label for="ID">National ID</label> <input type="number" name="ID" id="ID" /> </div>
        <div class="group-inputs"> <label for="ID">Account Number</label> <input type="number" name="ID" id="ID" /> </div>
        <div class="group-inputs"> <label for="ID">Swift Code</label> <input type="text" name="ID" id="ID" /> </div>
        <div class="btns-group"> <a href="#" class="btn btn-prev">Previous</a> <input type="submit" value="Submit" id="submit-form" class="btn" /> </div>
    </div>
</form>

</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script> 
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/scf.js') }}"></script> 
</body>
</html>