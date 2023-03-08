    
<div class="card">
    <div class="card-header">
    <a href="#" id="closesidenav" class="float-end"><i class="fas fa-times"></i></a>
    <h5 class="text-center text-success">{{ session()->get('schooldetails.name') }}</h5>
    <img src="{{ asset('images/' . session()->get('schooldetails.logo')) }}" class="img-fluid img-thumbnail" alt="">
  <!-- <img src="images/{{ session()->get('schooldetails.logo') }}" class=" img-fluid img-thumbnail" alt=""> -->
  <!-- <img src="{{ asset('images/$schoolinfo->logo') }}" class=" img-fluid img-thumbnail" alt=""> -->
</div>

<div class="card-body">
    <div class="sidenavlinks">
    <a href="/parentdashboard" class="text-decoration-none fs-5"><i class="fa fa-home"></i>&nbsp;My Students <span class="badge w3-yellow">{{ count($fnames) }}</span></a>
    <a href="{{ route('parent.profile') }}" class="text-decoration-none fs-5"><i class="fas fa-user-tie"></i>&nbsp;Profile</a>

    <!-- <a href="/communications" class="text-decoration-none fs-5"><i class="fas fa-sms"></i>&nbsp;Communicate</a> -->
    <a href="{{ route('parent.feestructure') }}" class="text-decoration-none fs-5"><i class="fas fa-print"></i>&nbsp;Fee Structures</a>
    <a href="{{ route('parent.notifications') }}" class="text-decoration-none fs-5"><i class="fas fa-bell"></i>&nbsp;Notifications <span class="badge w3-red">{{ count($notifications) }}</span></a>

    <button class="communicatebtn outline-none fs-5">
    <i class="fas fa-sms"></i>&nbsp;Communications
      <i id="commicon" class="fas fa-angle-left"></i><i id="commiconup" class="fas fa-angle-down d-none"></i>
    </button>
    <div id="commsdropdown" class="commsdropdown d-none w3-animate-top">
      <a href="{{ route('parent.messaging') }}" class="text-decoration-none fs-6"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Send Message to School</a>
      <a href="{{ route('parent.noticeboard') }}" class="text-decoration-none fs-6"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;Notice Board <span class="badge w3-red">{{ count($notices) }}</span></a>
      <a href="{{ route('parent.mymessages') }}" class="text-decoration-none fs-6"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i>&nbsp;My Send Messages <span class="badge w3-green">{{ count($mymessages) }}</span></a>
    </div>

    <a href="/fee-payment" class="text-decoration-none fs-5">LIPA FEES (M-PESA)</a>
    <a href="/parentlogin" class="text-decoration-none fs-5"><i class="fas fa-sign-out-alt"></i>&nbsp;LOGOUT</a>
  </div>
</div>

</div>
