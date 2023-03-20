<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontcss/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Shuleyetu</title>
</head>
<body id="landipgagebody">
<button class="btn btn-rounded-10 btn-sm w3-red" data-bs-toggle="modal" data-bs-target="#loginmodal" id="shake-btn"><i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp;Access your portal</button>
<div id="navbardiv">
<div id="brand">
    <a href="/"><span id="thelogo"><i>S</i></span><i>Shuleyetu</i></a>
</div>
<div id="landingpagenav" class="landingpagenav">
    <a href="#about" id="aboutnav">About Us</a>
    <a href="#contactsdiv2" id="contactsnav">Contacts</a>
    <a data-bs-toggle="modal" data-bs-target="#loginmodal" href="" id="loginnav">Login</a>
    <!-- <a href="" data-bs-toggle="modal" data-bs-target="#schoolregmodal" id="regnav">Register School</a> -->
    <a href="#modules" id="modulesnav">Modules & Services</a>
    <a href="#faqs" id="learnonlinenav">FAQs</a>
    <!--<a href="#" id="markertplacenav">Market Place</a>
    <a href="" id="plansnav">Teaching Vacancies</a> -->
</div>
<div class="closeopennav">
<a id="openbar" class="openbar" href=""><i class="fas fa-bars"></i></a>
<a id="closebar" class="closebar" href=""><i class="fas fa-times"></i></a>
</div>
</div>

<div id="smslandingpagenav" class="smslandingpagenav">
    <a href="#about" id="aboutnav">About Us</a>
    <a href="#contactsdiv2" id="contactsnav">Contacts</a>
    <a data-bs-toggle="modal" data-bs-target="#loginmodal" href="" id="loginnav">Login</a>
    <!-- <a href="" data-bs-toggle="modal" data-bs-target="#schoolregmodal" id="regnav">Register School</a> -->
    <a href="#modules" id="modulesnav">Modules & Services</a>
    <a href="#faqs" id="learnonlinenav">FAQs</a>
    <!--<a href="#" id="markertplacenav">Market Place</a>
    <a href="#" id="plansnav">Teaching Vacancies</a> -->
</div>

<div id="introduction" class="w3-green text-center p-4"><b>Digital Transformation for your school is here with you at hand. Centralize all your school operations in a single interface and a comprehensive platform that unites your students, staff, and parents.</b></div>

<!-- Slider Start-->
<div class="row justify-content-center" style="background-color: white; padding: 10px;">
<div class="col-lg-12 col-md-12 col-sm-12">
<div class="w3-content w3-display-container">

<div class="w3-display-container mySlides w3-animate-left">
  <img src="{{ asset('slides/studentportal.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Student Portal
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-top">
<img src="{{ asset('slides/staffportal.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Staff Portal
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-right">
<img src="{{ asset('slides/parentportal.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Parent Portal
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-bottom">
<img src="{{ asset('slides/studentperfoamncevisualiztion.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Perfomance Analysis and Visualization
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-zoom">
<img src="{{ asset('slides/periodicreporting.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Periodic Reports for Students
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-left">
<img src="{{ asset('slides/expensetracking.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Expense Tracking
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-left">
<img src="{{ asset('slides/finreportsgen.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Financial Reporting
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-top">
<img src="{{ asset('slides/librarymanagement.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Library Management
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-bottom">
<img src="{{ asset('slides/bulksmsmessaging.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Bulk SMS Messaging
  </div>
</div>

<div class="w3-display-container mySlides w3-animate-bottom">
<img src="{{ asset('slides/resultanalytics.PNG') }}" class="img-fluid img-thumbnail" alt="" style="width:100%">
  <div class="w3-display-bottomleft w3-indigo w3-padding-15 w3-large w3-container">
    Perfomance Analysis
  </div>
</div>

<!-- <div class="mySlides w3-display-container w3-animate-zoom w3-xlarge w3-green w3-card-4">
    <p class="text-center">Thank you! Choose us today and achieve digital tranformation for your school.</p>
    <p class="text-center">We are your number one partner in school management</p>
</div> -->

<button class="w3-button w3-display-left w3-indigo" onclick="plusDivs(-1)">&#10094;</button>
<button class="w3-button w3-display-right w3-indigo" onclick="plusDivs(1)">&#10095;</button>

</div>
</div>
</div>
<!-- Slider Start-->

<div id="about" class="row justify-content-center align-items-center mt-3">
    <div class="col-lg-8 col-md-10 col-sm-12 p-2" id="explanation">
    <h5 class="text-center text-info"><b>Who are we?</b></h5>
    <div class="realexplanation" id="aboutshuleyetu">
        <p>Shuleyetu is an online web based school management system. Shuleyetu was developed with one main objective, that is,
        to integrate modern technology in management of schools. Through Shuleyetu, everything becomes automated. The system is designed to accomodate both CBC and the ending 8-4-4 curriculums. It provides staff, student, and parent portals where
         the users can have a view of what pertains to them. With Shuleyetu, Parents do not
        have to come to school to see the progress of their children. Through the parents portal, a parent is able to monitor the progress, perfomance, fee balance and many more data
        of thier kids. The carefully designed staff portal enables perfomance automated perfomance of all the staff activities. Through the student Portal
        , students can monitor their perfomance, teacher reports and many other. With Shuleyetu everything is digitized.</p>
    </div>
    </div>
</div>


<div id="modules" class="row justify-content-center align-items-center mt-3 mb-0">
<h5 class="text-info text-center"><b>Features</b></h5>
    <div class="col-lg-12 col-md-12 col-sm-12" id="modulesservices">
        <!-- <div id="module">
            <h6>Students Management</h6>
            <hr>

        </div>

        <div id="module">
            <h6>Staff Management</h6>
            <hr>
            
        </div> -->
        <div class="row justify-content-center align-items-center">
            <div id="modulesmgmt" class="col-lg-5 col-md-6 col-sm-12">
             <h6><a href="" id="studentmgmt">Students Management <i class="fa fa-angle-down" id="icon1"></i></a></h6>
              <ol type="i" id="studentmgmtol">
                  <li>Register New Students.</li>
                  <li>Manage Registered Students.</li>
                  <li>Promote Students To Classes.</li>
                  <li>Manage Student Marks</li>
                  <li>Enroll Students to Subjects/Learning Areas.</li>
                  <li>Clear Students Who have Completed School</li>
              </ol>
             <h6><a href="" id="staffmgmt">Staff & Support Staff Management <i class="fa fa-angle-down" id="icon2"></i></a></h6>
                <ol type="i" id="staffmgmtol">
                    <li>Register New Teachers and Staff Members.</li>
                    <li>Manage Registered Staff and Teachers.</li>
                    <li>Manage their details</li>
                    <li>Manage Staff and Teacher Attendance</li>
                </ol>
            <h6><a href="" id="parentmgmt">Parents Management <i class="fa fa-angle-down" id="icon7"></i></a></h6>
                <ol type="i" id="parentmgmtol">
                    <li>Register New Parents' Details.</li>
                    <li>Manage Registered Parents.</li>
                    <li>Send Bulk Text SMS to Parents</li>
                    <li>Assign them details to access the system</li>
                </ol>
             <h6><a href="" id="academicmgmt">Academics Management <i class="fa fa-angle-down" id="icon3"></i></a></h6>
                <ol type="i" id="academicmgmtol">
                    <li>Register Subjects</li>
                    <li>Manage CBC Assessments</li>
                    <li>Manage 8-4-4 Examinations</li>
                    <li>Manage grading System</li>
                    <li>Give and review student periodic Reports</li>
                    <li>Auto-Grade Subjects</li>
                    <li>Auto-Compute Results</li>
                    <li>Print Results</li>
                    <li>Auto-generate transcripts</li>
                    <li>Auto-generate Result Slips</li>
                    <li>Send Results to Parents/Guardians</li>
                    <!-- <li>Thousands of Online Past Papers</li>
                    <li>Online Revision Materials</li>
                    <li>Assign Online Assignments To Students</li>
                    <li>Collect Assignments Online.</li> -->
                </ol>
             <h6><a href="" id="librarymgmt">Library Management <i class="fa fa-angle-down" id="icon4"></i></a></h6>
                <ol type="i" id="librarymgmtol">
                    <li>Add New Books.</li>
                    <li>Issue Books to Students & Staff.</li>
                    <li>Collect Issued Books</li>
                    <li>Compute Fine for delayed Return Date</li>
                </ol>
             <h6><a href="" id="financesmgmt">Finances Management <i class="fa fa-angle-down" id="icon5"></i></a></h6>
               <ol type="i" id="financemgmtol">
                    <li>Manage fee for each class and term</li>
                    <li>Generate fee structure.</li>
                    <li>Collect Fees</li>
                    <li>Track and Record Expenses</li>
                    <li>Auto-generate financial reports</li>
                    <li>Compare expenditures to fee collection.</li>
                    <li>Print Fee Receipt</li>
                    <li>Show Student Fee Payment History</li>
                    <!-- <li>M-PESA fee payment intergration (Advanced)</li> -->
                </ol>
             <h6><a href="" id="communicationmgmt">Communication Management <i class="fa fa-angle-down" id="icon6"></i></a></h6>
             <ol type="i" id="communicationmgmtol">
                <li>Manage Parents & staff Contacts</li>
                <li>Contact Parents through Bulk text SMS</li>
                <li>Contact Staff through Bulk text SMS</li>
                <li>Send Fee Reminders to Parents</li>
                <li>Send Assessment & Exam Results to Parents</li>
                <li>Send System Notifications to staff, parents and students</li>
             </ol>
             <h6><a href="" id="perfomanceanalysismgmt">Perfomance Analysis <i class="fa fa-angle-down" id="icon8"></i></a></h6>
             <ol type="i" id="perfomanceanalysismgmtol">
                <li>Comprehensive Class Perfomance Analysis</li>
                <li>Visualized Class Perfomance Analysis</li>
                <li>Individual Student Perfomance Analysis</li>
                <li>Class Subject Visualization</li>
             </ol>
            </div>
           
        </div>
    </div>
</div>

<!-- FAQS Start -->
<div id="faqs" class="row justify-content-center align-items-center mb-0">
    <h5 class="text-info text-center"><b>Frequently Asked Questions</b></h5>
    <div class="col-lg-12 col-md-12 col-sm-12 p-3">
        <ol type="1">
            <li><h6>I do not have a laptop, does that mean that I won't be able to use the system? <br><span class="text-danger"><b>Not having a laptop should not get you worried. The system has been designed following the principles of responsive web design. It scales to fit in screens of all sizes, everybody is able to use the system regardless of the device they are using.</b></span></h6></li>
            <li>
                <h6>Who can access the system? <span class="text-danger"><b>The system has the following portals</b></span></h6></li>
                <ul>
                    <li>Administrator Portal</li>
                    <li>Staff Portal</li>
                    <li>Student Portal</li>
                    <li>Parent Portal</li>
                </ul>
            </li>        
        </ol>
        <h5 class="text-center w3-green">To Book a Demo <b>CALL/SMS/WHATSAPP 0748269865</b></h5>
    </div>
</div>
<!-- FAQS End -->

<div id="contactsdiv2">
    <div id="contacts3">
    <div id="contacts">
        <h6>OUR CONTACTS</h6>
        <p>Need to get in touch with the kenyan <br> largest Learning Management System? Below are our contacts</p>
        <div id="contactlinks">
            <a href="tel:+254748269865"><i class="fas fa-phone"></i> Phone:&nbsp; 0748269865</a></br>
            <a href="https://api.whatsapp.com/send?phone=+254748269865&text=Hello there at shuleyetu?">WhatsApp:&nbsp; 0748269865</a><br>
            <a href="mailto:info@shuleyetu.co.ke?Subject=Hello Shuleyetu">Email:&nbsp; info@shuleyetu.co.ke</a>
         </div>
         <p>Contact Shuleyetu LMS today and get enrolled to the best Learning Management ERP.</p>
         <p>Shuleyetu is the best of the best</p>
    </div>

    <div id="quicklinks">
        <h6>QUICK LINKS</h6>
        <p><a href="">Who are we</a></p>
        <p><a href="">Staff Login</a></p>
        <p><a href="">Parent Login</a></p>
        <p><a href="">Student Login</a></p>
        <p><a href="">Register School</a></p>
        <p><a href="">Learn Online</a></p>
        <p><a href="">Market Place</a></p>
        <p><a href="">Our Pricing Plans</a></p>
    </div>

    <div id="services2">
        <h6>OUR SOLUTIONS</h6>
        <p>Student Management</p>
        <p>Staff Management</p>
        <p>Parents Management</p>
        <p>Academics Management</p>
        <p>Finance Management</p>
        <p>Communication Management</p>
        <p>Library Management</p>
        <p>Online Learning</p>
        <p>School Market</p>
    </div>

    <div id="contactform">
        <h6>MESSAGE US</h6>
        <form action="#" id="messageform" method="POST">
            @csrf
            <div class="registereqresponse2 d-none">

            </div>
            <div class="form-group mb-3">
            <input type="text" placeholder="Your Full Name e.g David Mudler" name="fullname" id="fullname" class="form-control">
            <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mb-3">
            <input type="number" placeholder="Your Phone Number e.g 0792801096" name="phoneno" id="phoneno" class="form-control">
            <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mb-3">
            <textarea placeholder="Type your message here" name="message" id="message" cols="30" rows="10" class="form-control">

            </textarea>
            <div class="invalid-feedback"></div>
            </div>
            <input id="msgbtn" type="submit" value="SEND MESSAGE" class="form-control btn btn-danger">
        </form>
    </div>

    </div>
    <p class="text-center">&copy; Copyright 2023 Shuleyetu | All Rights Reserved.</p>
    <!-- <div class="col-lg-10 col-md-10 col-sm-12">
        <div id="contacts" class="row justify-content-center">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <h5 class="text-center">Contacts</h5>
                <h6><a href="tel:+254792801096"><i class="fas fa-phone"></i> Phone:&nbsp; 0792801096</a></h6>
                <h6><a href="https://api.whatsapp.com/send?phone=+254748269865&text=Hello, Need assistance to register my school">WhatsApp:&nbsp; 0792801096</a></h6>
                <h6><a href="mailto:digischoollms@gmail.com?Subject=Hello DigiSchool">Email:&nbsp; digischoollms@gmail.com</a></h6>
            </div>

            <div class="col-lg-5 col-md-4 col-sm-12 p-3">
               <h5 class="text-center">Send Us Message</h5> 
                <form action="#" method="post">
                  <div class="form-group">
                      <label for=""><b>Your Full name</b></label>
                      <input type="text" name="fullname" id="fullname" placeholder="E.g David Mudler" class="form-control">
                  </div> 
                  <div class="form-group">
                      <label for=""><b>Your Phone Number</b></label>
                      <input type="text" name="phonenumber" id="phonenumber" placeholder="E.g 0792801096" class="form-control">
                  </div> 
                  <div class="form-group mb-2">
                      <label for=""><b>Message</b></label>
                      <textarea name="message" id="message" placeholder="Type your message here" cols="30" rows="10" class="form-control">

                      </textarea>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-danger btn-sm form-control">SEND MESSAGE</button>
                  </div> 
                </form>
            </div>
        </div>
    </div> -->
</div>


<!-- School add request modal end -->
<div class="modal w3-animate-left" id="schoolregmodal" tabindex="-1" aria-labelledby="promoteStudentModal">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel"><span id="titleadm" class="text-danger"></span> School Registration Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="registereqresponse d-none">
        Your School Registration Request has been submitted successfully. Our Team will reach back to you. Thank you.
        </div>
        <form id="registerrequestform" action="#" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label for=""><h6>Your Full Name</h6></label>
                <input type="text" placeholder="Your Full Name, e.g David Mudler" name="srfullname" id="srfullname" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
                <label for=""><h6>Phone Number</h6></label>
                <input type="number" placeholder="Your Phone Number, e.g 0792801096" name="srpnumber" id="srpnumber" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
                <label for=""><h6>Name of School</h6></label>
                <input type="text" placeholder="Name of your school, e.g BrightStars Academy" name="srsname" id="srsname" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
                <label for=""><h6>County Located</h6></label>
                <input type="text" placeholder="County Located, e.g Nakuru County" name="srcounty" id="srcounty" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
                <input type="checkbox" value="yes" name="regconfirmation" id="regconfirmation">&nbsp; Send Request?
                <div class="invalid-feedback"></div>
            </div>
            <input id="sendreqbtn" type="submit" value="SEND REQUEST" class="form-control btn-info btn-sm rounded-0">
        </form>
    </div>
    </div>
    </div>
</div>
<!-- School add request modal end -->

<!-- School add request modal end -->
<div class="modal w3-animate-left" id="loginmodal" tabindex="-1" aria-labelledby="promoteStudentModal">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header w3-white">
            <h6 class="modal-title text-success text-center"><b>Access your portal</b></h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h6><a class="btn btn-sm rounded-0 btn-success" href="/studentlogin"><i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp;Student Portal</a></h6>
            <h6><a class="btn btn-sm rounded-0 btn-success" href="/parentlogin"><i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp;Parent Portal</a></h6>
            <h6><a class="btn btn-sm rounded-0 btn-success" href="/adminlogin"><i class="fas fa-sign-in-alt" aria-hidden="true"></i>&nbsp;Staff Portal</a></h6>
        </div>
        </div>
        </div>
</div>
<!-- School add request modal end -->

  
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/fontjs/all.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.nav-toggle').click(function() {
            $('.nav-links').toggleClass('show');
        });

       $('#studentmgmt').click(function(e){
        e.preventDefault();
        //$('#studentmgmtol').toggleClass('d-none');
        $(this).toggleClass('hovered')
        $('#studentmgmtol').slideToggle('slow');
        $('#icon1').toggleClass('fa-angle-down fa-angle-up')
       }) 

       $('#staffmgmt').click(function(e){
        e.preventDefault();
        $(this).toggleClass('hovered')
        $('#staffmgmtol').slideToggle('slow');
        $('#icon2').toggleClass('fa-angle-down fa-angle-up')
       }) 

       $('#academicmgmt').click(function(e){
        e.preventDefault();
        $(this).toggleClass('hovered')
        $('#academicmgmtol').slideToggle('slow');
        $('#icon3').toggleClass('fa-angle-down fa-angle-up')
       })

       $('#librarymgmt').click(function(e){
        e.preventDefault();
        $(this).toggleClass('hovered')
        $('#librarymgmtol').slideToggle('slow');
        $('#icon4').toggleClass('fa-angle-down fa-angle-up')
       })

       $('#financesmgmt').click(function(e){
        e.preventDefault();
        $(this).toggleClass('hovered')
        $('#financemgmtol').slideToggle('slow');
        $('#icon5').toggleClass('fa-angle-down fa-angle-up')
       })

       $('#communicationmgmt').click(function(e){
        e.preventDefault();
        $(this).toggleClass('hovered')
        $('#communicationmgmtol').slideToggle('slow');
        $('#icon6').toggleClass('fa-angle-down fa-angle-up')
       })

       $('#perfomanceanalysismgmt').click(function(e){
        e.preventDefault();
        $(this).toggleClass('hovered')
        $('#perfomanceanalysismgmtol').slideToggle('slow');
        $('#icon8').toggleClass('fa-angle-down fa-angle-up')
       })

       $('#parentmgmt').click(function(e){
        e.preventDefault();
        $(this).toggleClass('hovered')
        $('#parentmgmtol').slideToggle('slow');
        $('#icon7').toggleClass('fa-angle-down fa-angle-up')
       })

       //Send Register Request Form Submission
       $('#registerrequestform').submit(function(e){
         removeValidationClasses($(this))
         $('#sendreqbtn').val('SENDING YOUR REQUEST...');
         e.preventDefault();
         var formdata = new FormData($(this)[0]);
         $.ajax({
             method: 'POST',
             url: '{{ route('reg.req') }}',
             contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            success: function(res) {
                if (res.status == 400) {
                $('#sendreqbtn').val('SEND REQUEST');
                showError('srfullname', res.messages.srfullname);
                showError('srpnumber', res.messages.srpnumber);
                showError('srsname', res.messages.srsname);
                showError('srcounty', res.messages.srcounty);
                showError('regconfirmation', res.messages.regconfirmation);
                } else if(res.status == 200){
                $('#registerrequestform')[0].reset();
                $('#sendreqbtn').val('SEND REQUEST');
                $('.registereqresponse').removeClass('d-none');
                $('.registereqresponse').text(res.messages);  
                }
            }
         })
     })

     //Send Us Message
     $('#messageform').submit(function(e){
         removeValidationClasses($(this))
         $('#msgbtn').val('SENDING YOUR MESSAGE...');
         e.preventDefault();
         var formdata = new FormData($(this)[0]);
         $.ajax({
             method: 'POST',
             url: '/regmessage',
             contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            success: function(res) {
                if (res.status == 400) {
                $('#msgbtn').val('SEND MESSAGE');
                showError('fullname', res.messages.fullname);
                showError('phoneno', res.messages.phoneno);
                showError('message', res.messages.message);
                
                } else if(res.status == 200){
                $('#messageform')[0].reset();
                $('#msgbtn').val('SEND MESSAGE');
                $('.registereqresponse2').removeClass('d-none');
                $('.registereqresponse2').text(res.messages);  
                }
            }
         })
     })

    //Work with opening and closing navabar
    $('#openbar').click(function(e){
        e.preventDefault();
        $('#smslandingpagenav').toggleClass('openedlandingpagenav smslandingpagenav')
        $('#smslandingpagenav').addClass('w3-animate-right');
    })

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
<script>
    // const navbarToggle = navbar.querySelector("#navbar-toggle");
    // const navbarMenu = document.querySelector("#navbar-menu");
    // const navbarLinksContainer = navbarMenu.querySelector(".navbar-links");
    // let isNavbarExpanded = navbarToggle.getAttribute("aria-expanded") === "true";

    // const toggleNavbarVisibility = () => {
    // isNavbarExpanded = !isNavbarExpanded;
    // navbarToggle.setAttribute("aria-expanded", isNavbarExpanded);
    // };

    // navbarToggle.addEventListener("click", toggleNavbarVisibility);

    // navbarLinksContainer.addEventListener("click", (e) => e.stopPropagation());
    // navbarMenu.addEventListener("click", toggleNavbarVisibility);

    //Work on animated btn
    const shakeBtn = document.querySelector('#shake-btn');
    setInterval(() => {
    shakeBtn.classList.add('shaking');
    setTimeout(() => {
        shakeBtn.classList.remove('shaking');
    }, 500);
    }, 2000);

</script>
<script>
var slideIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none"; 
  }
  slideIndex++;
  if (slideIndex > x.length) {slideIndex = 1} 
  x[slideIndex-1].style.display = "block"; 
  setTimeout(carousel, 5000); 
}
</script>
</body>
</html>