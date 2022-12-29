<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontcss/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>DigiSchool LMS</title>
</head>
<body id="landipgagebody">
<div id="landlogo" class="d-flex p-1">
    <a class="logoimg" href="/"><img class="img-fluid logo" src="images/logo2.jpg"></a>
</div>
<div class="landingpagenav">
    <a href="#aboutdigischool" id="aboutnav">About DigiSchool</a>
    <a href="#contactsdiv2" id="contactsnav">Contacts</a>
    <a href="" id="loginnav">Login</a>
    <a href="" data-bs-toggle="modal" data-bs-target="#schoolregmodal" id="regnav">Register School</a>
    <a href="#modules" id="modulesnav">Modules & Services</a>
    <a href="#" id="learnonlinenav">Learn Online</a>
    <a href="#" id="markertplacenav">Market Place</a>
    <a href="" id="plansnav">Pricing Plans</a>
</div>
<hr>

<div class="row">
    <div id="somediv" class="col-lg-6 col-md-6 col-sm-12 border border-success p-5">
      @if(count($schools) == 0)
      <div class="alert alert-info">
        <strong>
          DigiSchool Has Not Yet Registered a School. Take This Opportunity and Send Us a Request to Have Your School Registered. Click the button below to Send a Request for registering your school.
        </strong><br>
        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#schoolregmodal" type="button">Request for School Registration</button>
       </div>
         
        @else
        <div id="portalslinks">
            <a href="#">Student Portal</a>
            <a href="/parentlogin">Parent Portal</a>
            <a href="/adminlogin">Staff Portal</a>
        </div>
        <!-- <form action="#" class="bg-success p-3" id="login" method="post">
         <h5 class="text-center">LOGIN</h5>
              <div class="form-group mb-2">
                  <label for=""><h6 class="text-info">Select Your School</h6></label>
                  <select name="schoolselect" id="schoolselect" class="form-control">
                      <option value="">Select School</option>
                      @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                      @endforeach
                  </select>
              </div>

              <div class="form-group mb-2">
                  <label for=""><h6 class="text-info">Select Your Role</h6></label>
                  <select name="roleselect" id="roleselect" class="form-control">
                    <option value="">Select Role</option>
                    <option value="Student">Student</option>
                    <option value="Teacher">Staff</option>
                    <option value="Parent">Parent</option>
                  </select>
              </div>

            <div class="form-group">
              <input type="submit" value="PROCEED TO LOGIN" class="btn btn-sm btn-info form-control">
              </div>
          </form>  -->
        @endif
    </div>

    <div id="somediv2" class="col-lg-6 col-md-6 col-sm-12 border border-success p-5">
       <p>Need to automate the way activities run in your school? Then DigiShool LMS is the paltform you are looking for. With DigiSchool LMS there is no more need for
           paper work. Everything will run by th touch of a button. Teachers will no longer to struggle to compute results, the system will automate the proceess. 
           Parents can keep track of there kids progress without visiting the school. All they need to do is to log into the system and access the information regarding
            there kids such examination results, fee balance and any other key information they may require. Fee payment can be done through M-PESA and the system do the 
            necessary billing. Request for your School Enrollment to the platform and experience the best with us.  
       </p>
       <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#schoolregmodal" type="button">Request for School Registration</button>
       
    </div>
</div>

<div class="row justify-content-center align-items-center mt-3">
    <div class="col-lg-8 col-md-10 col-sm-12 p-2" id="explanation">
    <h5 class="text-center text-info"><b>Who are we?</b></h5>
    <div class="realexplanation" id="aboutdigischool">
        <p>Digischool LMS is an online web based school management system. Digischool was developed with one main objective, that is,
        to ease the management of a school through technology. When you Join DigiSchool, there is no any more need for paper work.
        Everything becomes automated. All you do is register all the students,parents and staff members. With DigiSchool, Parents do not
        have to come to school to see the progress of their children. DigiSchool allows parents to log into the system and monitor the progress
        of thier kids. From the dashboard, they are able to see their childrens scores and fee balance. Teachers do not have to get tired computing
        results, Digischool automates the whole process. DigiSchool is the techology that each school needs to absorb.</p>
    </div>
    </div>
</div>


<div class="row justify-content-center align-items-center mt-3 mb-3">
    <div class="col-lg-8 col-md-10 col-sm-12" id="modulesservices">
        <h5 class="text-center text-danger"><b>Modules & Services</b></h5>
        <h6 class="text-center">Ever wondered what DigiSchool can achieve you achieve? Well, DigiSchool offers the following broad categories of services for school management</h6>
        <div id="modules" class="row justify-content-center align-items-center">
            <div id="modulesmgmt" class="col-lg-5 col-md-6 col-sm-12">
             <h6><a href="" id="studentmgmt">Students Management <i class="fa fa-angle-down" id="icon1"></i></a></h6>
              <ol type="i" id="studentmgmtol">
                  <li>Register New Students.</li>
                  <li>Manage Registered Students.</li>
                  <li>Promote Students To Classes.</li>
                  <li>Manage Students Class Attendance</li>
                  <li>Clear Students Who have Completed School</li>
              </ol>
             <h6><a href="" id="staffmgmt">Staff & Support Staff Management <i class="fa fa-angle-down" id="icon2"></i></a></h6>
                <ol type="i" id="staffmgmtol">
                    <li>Register New Staff Members.</li>
                    <li>Manage Registered Staff.</li>
                </ol>
            <h6><a href="" id="parentmgmt">Parents Management <i class="fa fa-angle-down" id="icon7"></i></a></h6>
                <ol type="i" id="parentmgmtol">
                    <li>Register New Parents.</li>
                    <li>Manage Registered Parents.</li>
                    <li>Send Bulk Text SMS to Parents</li>
                    <li>Send Emails To Parents</li>
                </ol>
             <h6><a href="" id="academicmgmt">Academics Management <i class="fa fa-angle-down" id="icon3"></i></a></h6>
                <ol type="i" id="academicmgmtol">
                    <li>Register Subjects</li>
                    <li>Manage Subjects</li>
                    <li>Manage Timetabling</li>
                    <li>Manage Subjects grading System</li>
                    <li>Manage overall Class grading system</li>
                    <li>Register Exams</li>
                    <li>Manage Terms</li>
                    <li>Manage Term Dates</li>
                    <li>Auto-Grade Subjects</li>
                    <li>Auto-Compute Results</li>
                    <li>Print Results</li>
                    <li>Auto-generate transcripts</li>
                    <li>Auto-generate Result Slips</li>
                    <li>Thousands of Online Past Papers</li>
                    <li>Online Revision Materials</li>
                    <li>Assign Online Assignments To Students</li>
                    <li>Collect Assignments Online.</li>
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
                    <li>Set Fee for term for each Class</li>
                    <li>Generate fee structure.</li>
                    <li>Collect Fees</li>
                    <li>Auto-generate fee Statement</li>
                    <li>M-PESA fee payment intergration</li>
                </ol>
             <h6><a href="" id="communicationmgmt">Communication Management <i class="fa fa-angle-down" id="icon6"></i></a></h6>
             <ol type="i" id="communicationmgmtol">
                <li>Manage Parents & staff Contacts</li>
                <li>Contact Parents through Bulk text SMS</li>
                <li>Contact Staff through Bulk text SMS</li>
                <li>Send Emails to Parents/Staff</li>
             </ol>
            </div>
           
        </div>
    </div>
</div>

<div id="contactsdiv2">
    <div id="contacts3">
    <div id="contacts">
        <h6>OUR CONTACTS</h6>
        <p>Need to get in touch with the kenyan <br> largest Learning Management System? Below are our contacts</p>
        <div id="contactlinks">
            <a href="tel:+254792801096"><i class="fas fa-phone"></i> Phone:&nbsp; 0792801096</a></br>
            <a href="https://api.whatsapp.com/send?phone=+254748269865&text=Hello, Need assistance to register my school">WhatsApp:&nbsp; 0792801096</a><br>
            <a href="mailto:digischoollms@gmail.com?Subject=Hello DigiSchool">Email:&nbsp; digischoollms@gmail.com</a>
         </div>
         <p>Contact DigiSchool LMS today and get enrolled to the best Learning Management ERP.</p>
         <p>DigiSchoolLMS is the best of the best</p>
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
    <p class="text-center">&copy; Copyright 2022 DigiSchoolLMS | All Rights Reserved.</p>
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

  
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/fontjs/all.min.js') }}"></script>
<script>
    $(document).ready(function(){
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