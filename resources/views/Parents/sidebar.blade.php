    
<div class="card">
    <div class="card-header">
    <a href="#" id="closesidenav" class="float-end"><i class="fas fa-times"></i></a>
    <h5 class="text-center text-success">{{ session()->get('schooldetails.name') }}</h5>
  <img src="images/{{ session()->get('schooldetails.logo') }}" class=" img-fluid img-thumbnail" alt="">
  <!-- <img src="{{ asset('images/$schoolinfo->logo') }}" class=" img-fluid img-thumbnail" alt=""> -->
</div>

<div class="card-body">
    <div class="sidenavlinks">
    <a href="/parentdashboard" class="text-decoration-none fs-5"><i class="fas fa-users"></i>&nbsp;My Students</a>
    <a href="{{ route('parent.profile') }}" class="text-decoration-none fs-5"><i class="fas fa-user-tie"></i>&nbsp;Profile</a>

    <!-- <a href="/communications" class="text-decoration-none fs-5"><i class="fas fa-sms"></i>&nbsp;Communicate</a> -->
    <a href="/parentnotifications" class="text-decoration-none fs-5"><i class="fas fa-bell"></i>&nbsp;Notifications</a>

    <button class="communicatebtn outline-none fs-5">
    <i class="fas fa-sms"></i>&nbsp;Communicate
      <i id="commicon" class="fas fa-angle-left"></i><i id="commiconup" class="fas fa-angle-down d-none"></i>
    </button>
    <div id="commsdropdown" class="commsdropdown d-none w3-animate-top">
      <a href="{{ route('parent.messaging') }}" class="text-decoration-none fs-6"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Send Message to School</a>
    </div>

  </div>
</div>

</div>
