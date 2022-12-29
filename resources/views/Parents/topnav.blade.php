
<div id="topnavdiv" class="topnavdiv">
<div class="topnav">
        <a href="" class="text-decoration-none text-danger fs-4 navtoggler"><i class="fas fa-bars"></i></a>
        <a href="#" class="text-decoration-none text-info" id="user">Parent's Portal</a>
        <a href="#" class="text-decoration-none logouticon link-success">
         <img id="navprofile" src="images/{{ session()->get('LoggedInUser.Profile') }}" class="img-rounded" alt="">
        </a>  


</div>
<h6 class="text-center"><b><span class="text-danger">{{ session()->get('schooldetails.name') }}</span>, <span class="text-success">{{ session()->get('schooldetails.motto') }}</span></b></h6>
<div class="row d-flex" id="greeting">
        <div class="col-lg-6 justify-content-center align-items-center">
        <h6 style="background-color: #e6e6e6; font-size: 15px;" class="text-center p-2"><span class="text-danger"><b id="greetuser"></b></span> {{ session()->get('LoggedInUser.Fname') }} {{ session()->get('LoggedInUser.Lname') }}</h6>
        </div>

        <div class="col-lg-6 justify-content-center align-items-center">
        <h6 style="background-color: #e6e6e6; font-size: 15px;" class="text-center p-2"><span id="date"></span>-<span id="month">-</span>-<span id="year"></span> <b style="font-size: 15px;"><span id="hour"></span>:<span id="minute"></span>:<span class="text-danger" id="second"></span></b></h6>
        </div>
<hr>
<div id="subregdiv"></div>
</div>
</div>
