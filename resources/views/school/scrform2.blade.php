<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scf2.css') }}" rel="stylesheet">
    <title>School Register</title>
</head>
<body>
    
    <!-- MultiStep Form -->
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Register The School Details Here</strong></h2>
                <ul class="alert alert-warning d-none p-5" id="save_errorlist">

                </ul>
                <div class="sreg_success">

                </div>
                <p>Fill all form field to go to next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="POST" action="#" enctype="multipart/form-data">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Account</strong></li>
                                <li id="personal"><strong>Contacts</strong></li>
                                <li id="payment"><strong>Profile</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">School Details</h2>
                                    @csrf
                                    <input id="schoolname" type="text" name="schoolname" placeholder="Enter The School Name" />
                                    <select class="form-control mb-2" name="schoollevel" id="schoollevel">
                                        <option value="">Select the level of the School</option>
                                        <option value="PrimarySchool">Primary School</option>
                                        <option value="SecondarySchool">Secondary School</option>
                                    </select>
                                    
                                    
                                    <input id="motto" type="text" name="motto" placeholder="School Motto" /> 
                                </div> 
                                <input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">School Contacts</h2> 
                                    <input id="email" type="email" name="semail" placeholder="School Email" /> 
                                    <input id="phone" type="tel" name="primaryphone" placeholder="Phone Number" /> 
                                    <input id="altphone" type="tel" name="altphone" placeholder="Alternative Phone Number" /> 
                                    <input id="pobox" type="text" name="pobox" placeholder="Enter PO-BOX" />
                                    <input id="town" type="text" name="town" placeholder="PO-BOX Town" />
                                </div> 
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                                <input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">School Logo</h2>
                                    <p class="text-success">Select Your School Logo(Will appear in all sytem auto-generated files)</p>
                                
                                    <input class="form-control" id="logo" onchange="preview()" type="file" name="logo"/>
                                
                                    <div class="logo-preview d-flex justify-content-center">
                                        <img src="" id="frame" class="img-fluid" alt="LOGO">
                                    </div>
                                </div> 
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                                <input type="button" name="make_payment" class="next action-button" value="Finish" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title text-center">Almost There! Final step !</h2> <br><br>
                                    
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5>Click the Button Below to Submit the School Details</h5>
                                        </div>
                                    
                                        <div class="form-group">
                                            <input type="submit" id="submitbtn" class="btn btn-info" value="REGISTER SCHOOL">
                                        </div>
                                        
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script> 
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/scf2.js') }}"></script>
<script>
    function preview(){
        frame.src=URL.createObjectURL(event.target.files[0]);
    }
</script>
<script>
$(function(){
    
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
                        $('#submitbtn').val('REGISTER SCHOOL');
                        window.location = '{{ route('adminregister') }}'
                    }
               }
           }) 
}) 
})
</script>
</body>
</html>