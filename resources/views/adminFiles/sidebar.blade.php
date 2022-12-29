    
<div class="card">
    <div class="card-header">
    <a href="#" id="closesidenav" class="float-end"><i class="fas fa-times"></i></a>
    <h5 class="text-center text-success">{{ session()->get('schooldetails.name') }}</h5>
  <img src="images/{{ session()->get('schooldetails.logo') }}" class=" img-fluid img-thumbnail" alt="">
  <!-- <img src="{{ asset('images/$schoolinfo->logo') }}" class=" img-fluid img-thumbnail" alt=""> -->
</div>

<div class="card-body">
    <div class="sidenavlinks">
    <a href="/admindashboard" class="text-decoration-none fs-5"><i class="fas fa-tachometer-alt"></i>&nbsp;DashBoard</a>
    <a href="/adminprofile" class="text-decoration-none fs-5"><i class="fas fa-user-tie"></i>&nbsp;Profile</a>
    <button class="financesbtn outline-none fs-5">
    <i class="fas fa-money-bill"></i>&nbsp;Finances
      <i id="finicon" class="fas fa-angle-left"></i><i id="finiconup" class="fas fa-angle-down d-none"></i>
    </button>
    <div id="findropdown" class="finances-dropdown d-none w3-animate-zoom">
      <a href="/feestructure"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Fee Structure</a>
      <a href="/feecollection"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Collect Fee</a>
      <a href="/expenses"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Record Expenses</a>
      <a href="/financereport"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Financial Report</a>
      <!-- <a href="/procurements"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Procurements</a> -->
    </div>

    <button class="peoplebtn outline-none fs-5">
    <i class="fas fa-users"></i>&nbsp;People
      <i id="peopleicon" class="fas fa-angle-left"></i><i id="peopleiconup" class="fas fa-angle-down d-none"></i>
    </button>
    <div id="peopledropdown" class="people-dropdown d-none w3-animate-left">
      <a href="/students"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Students</a>
      <a href="/teachers"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Teachers</a>
      <a href="/parents"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Parents</a>
      <a href="/staff"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Support staff</a>
    </div>

    <button class="academicbtn outline-none fs-5">
    <i class="fas fa-user-graduate"></i>&nbsp;Academics
      <i id="acadicon" class="fas fa-angle-left"></i><i id="acadiconup" class="fas fa-angle-down d-none"></i>
    </button>
    <div id="academicdropdown" class="academics-dropdown d-none w3-animate-bottom">
      <a href="/classes"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Classes</a>
      <a href="/subjects"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Subjects</a>
      <a href="/gradingsystem"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Grading System</a>
      <!-- <a href="/terms"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Terms</a>
      <a href="/currentterm"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Set Current Term</a> -->
      <a href="/examinations"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Examinations</a>
      <a href="/examresthread"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Results Thread</a>
      <a href="/autoresults"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Per Subject result auto-compute</a>
      <a href="/finalresults"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Final Results Computation</a>
      <a href="/resultanalysis"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Result Analysis</a>
    </div>
    <button class="librarybtn outline-none fs-5">
    <i class="fas fa-book-reader"></i>&nbsp;Library
      <i id="libicon" class="fas fa-angle-left"></i><i id="libiconup" class="fas fa-angle-down d-none"></i>
    </button>
    <div id="libdropdown" class="library-dropdown d-none w3-animate-right">
      <!-- <a href="/library"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Librarians</a> -->
      <a href="/books"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Manage Resources</a>
    </div>

    <button class="communicatebtn outline-none fs-5">
    <i class="fas fa-sms"></i>&nbsp;Communicate
      <i id="commicon" class="fas fa-angle-left"></i><i id="commiconup" class="fas fa-angle-down d-none"></i>
    </button>
    <div id="commsdropdown" class="commsdropdown d-none w3-animate-top">
      <!-- <a href="/library"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Librarians</a> -->
      <a href="/communications" class="text-decoration-none"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Send SMS Message</a>
      <a href="{{ route('admin.notify') }}" class="text-decoration-none"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Send Notifications</a>
      <a href="/communicationhistory" class="text-decoration-none"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Communication History</a>
    </div>


    <!-- <a href="/communications" class="text-decoration-none fs-5"><i class="fas fa-sms"></i>&nbsp;Communicate</a> -->
    <a href="{{ route('admin.notifications') }}" class="text-decoration-none fs-5"><i class="fas fa-bell"></i>&nbsp;Notifications</a>
    <!-- <a href="/clubs" class="text-decoration-none fs-5"><i class="fas fa-user-friends"></i>&nbsp;Clubs</a> -->
    <a href="/" class="text-decoration-none fs-5">&nbsp;LOGOUT</a>
    <!-- <a href="/departments" class="text-decoration-none fs-5"><i class="fas fa-building"></i>&nbsp;Departments</a>
    <a href="/suppliers" class="text-decoration-none fs-5"><i class="fas fa-truck"></i>&nbsp;Suppliers</a> -->
    <!--
      <a href="/expenses" class="text-decoration-none fs-5"><i class="fas fa-money-bill-wave"></i>&nbsp;Expenses</a>
    <a href="/procurements" class="text-decoration-none fs-5"><i class="fas fa-money-bill"></i>&nbsp;Procurements</a>
      <a href="/subjects" class="text-decoration-none fs-5"><i class="fas fa-book"></i>&nbsp;Subjects</a>
      <a href="/classes" class="text-decoration-none fs-5"><i class="fas fa-school"></i>&nbsp;Classes</a>
    <a href="/library" class="text-decoration-none fs-5"><i class="fas fa-book-reader"></i>&nbsp;Library</a>
    <a href="/students" class="text-decoration-none fs-5"><i class="fas fa-users"></i>&nbsp;Students</a>
    <a href="/teachers" class="text-decoration-none fs-5"><i class="fas fa-users"></i>&nbsp;Teachers</a>
    <a href="/parents" class="text-decoration-none fs-5"><i class="fas fa-users"></i>&nbsp;Parents</a>
    <a href="/staff" class="text-decoration-none fs-5"><i class="fas fa-users"></i>&nbsp;Support Staff</a>
  -->
  </div>
</div>

</div>
