@extends('layouts.layout')

@section('title','Fee Structure')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Parents.sidebar')
</div>
<div id="main" class="maincontent">

@include('Parents.topnav')
<!---View  fee structure modal start--->
<div id="viewFeetrstructureModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div id="feestucturediv">
                <h5 class="text-center text-danger">{{ session()->get('schooldetails.name') }}</h5>
                <h6 class="text-center w3-green p-2"><span id="fclass"></span>&nbsp;Fee Structure</h6>
                <table id="" class="table">
                    <thead>
                        <tr> 
                        <th scope="col">Item</th>
                        <th scope="col">Amount</th> 
                        </tr>
                    </thead>
                    <tbody id="itemamount">
                        
                    </tbody>
                </table>
            </div>
        </div>

        </div>

      </div>
    </div>
  </div>
</div>
<!--View fee structure modal end--->

<div class="row justify-content-center align-items-center">
    <div class="col-lg-6 col-md-6 col-sm-10">
        <form action="#" id="searchfeestructureform" method="POST">
        <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
            <div class="form-group mb-2">
                <label for=""><b>Select Class</b></label>
                <select name="class" id="class" class="form-control">
                    <option value="">Select Class</option>
                    @foreach($classes as $class) 
                    <option value="{{ $class['id'] }}">{{ $class['class'] }} {{ $class['stream'] }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mb-2">
            <label for=""><b>Select Term</b></label>
                <select name="term" id="term" class="form-control">
                    <option value="">Select Term</option>
                    <option value="TERM ONE">TERM ONE</option>
                    <option value="TERM TWO">TERM TWO</option>
                    <option value="TERM THREE">TERM THREE</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <input type="submit" id="viewfeestrbtn" value="VIEW FEE STRUCTURE" class="form-control btn-sm btn btn-rounded-0 w3-green">
        </form>
    </div>
</div>
 
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
    $(document).ready(function(){
        //setting csrf token
        $.ajaxSetup({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

      //Submit Fee Structure Query
      $("#searchfeestructureform").submit(function(e){
        e.preventDefault();
        $("#viewfeestrbtn").val('PLEASE WAIT...');
        removeValidationClasses($("#searchfeestructureform"));
        var sid = "{{ session()->get('schooldetails.id') }}";
        var cls = $("#class").val();
        var term = $("#term").val();

            $.ajax({
                url: '/searchfeestructure',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    console.log(res)
                    if (res.status == 400) {
                        showError('term',res.messages.term);
                        showError('class',res.messages.class);
                        $('#viewfeestrbtn').val('VIEW FEE STRUCTURE');
                    } else if (res.status == 200) {
                        $('#viewfeestrbtn').val('VIEW FEE STRUCTURE');

                        if (res.feestructure.length == 0) {
                            $("#feestucturediv").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! The fee structure you are requesting has not been set.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

                            $("#viewFeetrstructureModal").modal('show'); 
                        } else {
                           $("#fclass").text(res.feestructure[0].classnames)  

                            var items = res.feestructure[0].modules.split(",");

                            var amounts = res.feestructure[0].amounts.split(",");

                            $("#itemamount").html("");
                            
                            for (let k = 0; k < items.length; k++) {
                                //const element = items[k];
                                $("#itemamount").append('<tr>\
                                    <td>'+items[k]+'</td>\
                                    <td>'+amounts[k]+'</td>\
                                </tr>');   
                            }

                            $("#itemamount").append('<tr>\
                                <td><b>Total</b></td>\
                                <td><b>'+res.feestructure[0].totalamount+'</b></td>\
                            </tr>') 

                            $("#viewFeetrstructureModal").modal('show')  
                        }
                    }
                }
            })
        
      })

    })
</script>
@endsection