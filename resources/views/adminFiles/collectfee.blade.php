@extends('layouts.layout')

@section('title','Fee Collection')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')
<!--Collect Fee modal start--->
<div id="collectFeeModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title text-success">Collect Fee</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="receivefeeform" action="#" method="post">
            <input type="number" name="stuid2" id="stuid2" hidden>
            <input type="text" name="studentadmupi" id="studentadmupi" hidden>
            <input type="text" name="studentacayear" id="studentacayear" hidden>
            <input type="text" name="termpayed" id="termpayed" hidden>
            <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-2">
                    <label for=""><h6 class="text-danger">Pending Fee Arrears</h6></label>
                    <input type="number" name="pendingarrears2" id="pendingarrears2" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-2">
                        <label for=""><h6 class="text-danger">Current Term Balance</h6></label>
                        <input type="number" name="pendingtermbalance" id="pendingtermbalance" class="form-control" readonly>
                    </div>
                </div>
            </div>  

          <div class="form-group mb-2">
            <label for=""><h6 class="text-danger">Total Fee Debt</h6></label>
            <input type="number" name="totalfeedebt" id="totalfeedebt" class="form-control" readonly>
          </div>

          <div class="form-group mb-2">
            <label for=""><h6 class="text-danger">Payment Method</h6></label>
            <div class="form-group">
                <select name="paymentmethod" id="paymentmethod" class="form-control">
                    <option value="">Select Payment Method</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                    <option value="MPESA">M-PESA</option>
                    <option value="Bursary">Bursary</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
          </div>

          <div id="paymentcode" class="form-group mb-2 w3-animate-zoom">
            <label for=""><h6 class="text-danger">Cheque Number or MPESA Code</h6></label>
            <input type="text" name="transcationcode" id="transcationcode" class="form-control">
            <div class="invalid-feedback"></div>
          </div>

          <!-- <div class="form-group mb-2">
            <label for=""><h6 class="text-danger">Payed for</h6></label>
            <div class="form-group">
                <select name="payedfor" id="payedfor" class="form-control">
                    <option value="">Payed for</option>
                    <option value="Pending Arrears">Pending Arrears</option>
                    <option value="Current Term">Current Term Balance</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
          </div> -->

          <div class="form-group mb-2">
            <label for=""><h6 class="text-danger">Amount Paid</h6></label>
            <input type="number" name="amountreceived" id="amountreceived" class="form-control">
            <div class="invalid-feedback"></div>
          </div>

          <div class="form-group mb-2">
            <input type="submit" value="SUBMIT FEE PAYMENT" id="receivefeesubmit" class="form-control btn btn-sm rounded-0 w3-indigo">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Collect Fee modal end--->

<!--Payment Receipt modal start--->
<div id="feepaymentModal" class="modal w3-animate-bottom" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
      </div>
    </div>
  </div>
</div>
<!--Payment Receipt modal end--->

<!--Payment Receipt modal div--->
<div id="receiptdiv" class="w3-animate-left d-none">
    <button id="downloadfeepaymentreceipt" class="btn w3-red btn-sm mb-1"><i class="fas fa-file-pdf"></i>&nbsp;DOWNLOAD</button>
    <button id="printfeepaymentreceipt" class="btn w3-green btn-sm mb-1"><i class="fas fa-print"></i>&nbsp;PRINT</button>
<div id="innerreceiptdiv">
    <h5 class="text-center text-danger">{{ session()->get('schooldetails.name') }}</h5>
    <h6 class="text-center text-success">{{ session()->get('schooldetails.motto') }}</h6>
    <h6 class="text-center text-info">{{ session()->get('schooldetails.pobox') }} {{ session()->get('schooldetails.town') }}, {{ session()->get('schooldetails.phone') }}</h6>
    <hr>
    <h5 class="text-center">FEE PAYMENT RECEIPT</h5>
    <h6>Student Name: <span class="text-success" id="stufeepaymentname"></span></h6>
    <h6>Admission Number: <span class="text-success" id="stufeepaymentadmnumber"></span></h6>
    <h6>UPI Number: <span class="text-success" id="stufeepaymentupinumber"></span></h6>
    <h6>Current Class: <span class="text-success" id="stufeepaymentcclass"></span></h6>
    <h6>Current Term: <span class="text-success" id="stufeepaymentcterm"></span></h6>
    <hr>
    <h6 class="">Initial Pending Balance <span class="text-danger" id="initialpbalance"></span>/=</h6>
    <h6 class="">Initial Current Term Balance <span class="text-danger" id="initialcbalance"></span>/=</h6>
    <h6 class="">Initial Overall Balance <span class="text-danger" id="initialovbalance"></span>/=</h6>
    <h5 class="text-center">Amount Received <span class="text-danger" id="feeamountreceived"></span>/=</h5>
    <h6>Current Pending Balance <span class="text-danger" id="afterpaypendingbalance"></span>/=</h6>
    <h6>Current Term Balance <span class="text-danger" id="afterpaytermbalance"></span>/=</h6>
    <h6>Current Overall Balance <span class="text-danger" id="afterpayovbalance"></span>/=</h6>
    <hr>
    <h6>Fee Received By <span id="payreceivedby"></span></h6>
    <p>Signature _____________________</p>
    <h6>Date <span id="paymentdate"></span></h6>
</div>
<button id="closereceipt" class="btn w3-red float-end btn-sm">Close</button>
</div>
<!--Payment Receipt modal div--->

<div class="row justify-content-center">
    <div id="response"></div>
    <div class="col-lg-4 col-md-8 col-sm-10">
        <form action="#" id="searchstudent" method="post">
            <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
            <div class="form-group p-2">
                <label for=""><h6 class="text-danger">Enter UPI or Admission to Search</h6></label>
                <input type="text" placeholder="Admission or UPI Number" name="searchnumber" id="searchnumber" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group p-2">
            <button type="submit" id="searchnumberbtn" class="btn btn-sm rounded-0 w3-green form-control"><i class="fas fa-search"></i> SEARCH STUDENT</button>
            </div>
        </form>
    </div>

    <div class="col-lg-4 col-md-8 col-sm-10">
      <div class="w3-green w3-animate-left p-2 d-none" id="studentinfo">
        <h4 class="text-center" id="studentname"></h4>
        <h6 class="text-center">Admission No: <b><span id="admnumber"></span></b></h6>
        <h6 class="text-center">UPI No: <b><span id="upinumber"></span></b></h6>
        <h6 class="text-center">Class: <b><span id="cclass"></span></b></h6>
        <h6 class="text-center">Term: <b><span id="term"></span></b></h6>
        <h6 class="text-center mb-1">Pending Fee Arrears: <b><span class="text-danger p-2" id="pendingarrears"></span>/=</b></h6>
        <h6 class="text-center mb-1">Current Term Balance: <b><span class="text-danger p-2" id="ctermbalance"></span>/=</b></h6>
        <h6 class="text-center mb-1">Total Fee Debt: <b><span class="text-danger p-2" id="feedebt"></span>/=</b></h6>

      </div>  
    </div>

    <div class="col-lg-4 col-md-8 col-sm-10">
       <div id="feestructure" class="d-none w3-animate-right">
        <h6 class="text-center text-danger"><span id="feestrutureheading"></span> Fee Structure</h6>
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

<!-- <hr> -->
<div class="row justify-content-center align-items-center">
    <div id="feeinformation" class="d-none w3-animate-bottom">
    <p>The system found that <b><span class="text-danger" id="stuname"></span></b> has a pending fee balance (Fee Arrears related to previous terms term) of <b><span class="text-danger" id="pendbalance"></span></b> and a balance of <b><span class="text-danger" id="ctermbal"></span></b> for the current term which gives a total of <b><span class="text-danger" id="totalbal"></span></b>. If you think the information is not true then you can edit using the form fields below.</p>
    <div id="response2"></div> 
    <div class="col-lg-4 col-md-8 col-sm-12">
        <form action="#" class="p-2" id="editfeeinformation" method="post">
            <input type="number" name="stuid" id="stuid" hidden>
            <div class="form-group">
                <label for=""><h6 class="text-danger">Pending Fee Balance (Arrears for last term)</h6></label>
                <input type="number" name="pendingbalancefield" id="pendingbalancefield" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for=""><h6 class="text-danger">Current Term Balance <span class="text-success" id="ctermlable"></span></h6></label>
                <input type="number" name="ctermbalancefield" id="ctermbalancefield" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group mb-2">
                <label for=""><h6 class="text-danger">Total Fee Debt</h6></label>
                <input type="number" name="totalfeedebtfield" id="totalfeedebtfield" class="form-control" readonly>
            </div>

            <div class="form-group mt-2">
                <input type="submit" value="UPDATE FEE INFORMATION" id="submitfeeinformation" class="form-control btn btn-sm rounded-0 w3-green">
            </div>
        </form>
    </div>
    </div>
</div>
  
<!-- <hr> -->
<div id="feepaymentdiv" class="row justify-content-center align-items-center d-none">
    <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
        <button id="feecollectbtn" class="btn btn-info w3-indigo">Collect Fee</button>
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

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        var filename = ""

        //Submit Search Student Form
        $('#searchstudent').submit(function(e){
         //$('#searchnumberbtn').text('SEARCHING...');
         removeValidationClasses($('#searchstudent'));
         $("#studentinfo").addClass("d-none");
         $("#feestructure").addClass("d-none");
         $("#feeinformation").addClass("d-none");
         $("#feepaymentdiv").addClass("d-none");
         e.preventDefault();
         var formdata = new FormData($(this)[0]);
            $.ajax({
                method: 'POST',
                url: '/searchstudent',
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formdata,
                success: function(res) {
                    //$('#searchnumberbtn').text('SEARCH STUDENT');
                    //console.log(res);
                    if (res.status == 400) {
                        showError('searchnumber', res.messages.searchnumber); 
                    } else if (res.status == 401){
                        $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    } else if (res.status == 200) {
                        $('#searchstudent')[0].reset();
                        $("#studentinfo").removeClass("d-none");
                        $("#feeinformation").removeClass("d-none");
                        $("#feepaymentdiv").removeClass("d-none");
                        $("#studentname").text(`${res.student[0].Fname} ${res.student[0].Lname}`);
                        $("#admnumber").text(res.student[0].AdmissionNo);
                        $("#upinumber").text(res.student[0].UPI);
                        $("#cclass").text(res.student[0].current_class);
                        $("#term").text(res.class.current_term);
                        //$("#studentacayear").val(res.class.);
                        $("#pendingarrears").text(res.student[0].pendingbalances);
                        $("#pendingarrears2").val(res.student[0].pendingbalances);
                        $("#pendingtermbalance").val(res.student[0].feebalance);
                        $("#totalfeedebt").val(res.student[0].ovbalance);
                        $("#ctermbalance").text(res.student[0].feebalance);
                        $("#feedebt").text(res.student[0].ovbalance);
                        $("#stuname").text(`${res.student[0].Fname} ${res.student[0].Lname}`);
                        $("#pendbalance").text(res.student[0].pendingbalances);
                        $("#ctermbal").text(res.student[0].feebalance);
                        $("#totalbal").text(res.student[0].ovbalance);
                        $("#pendingbalancefield").val(res.student[0].pendingbalances);
                        $("#ctermbalancefield").val(res.student[0].feebalance);
                        $("#totalfeedebtfield").val(res.student[0].ovbalance);
                        $("#stuid").val(res.student[0].id);
                        $("#stuid2").val(res.student[0].id);
                        $("#studentadmupi").val(res.upiadm);
                        $("#studentacayear").val(res.class.class);
                        $("#termpayed").val(res.class.current_term);


                        $("#feestrutureheading").text(`${res.feestructure[0].classnames} ${res.feestructure[0].Term}`)
                        $("#ctermlable").text(`${res.feestructure[0].classnames} ${res.feestructure[0].Term}`)
                        
                        $("#feestructure").removeClass("d-none");

                        var items = res.feestructure[0].modules.split(",");
                        var amounts = res.feestructure[0].amounts.split(",");

                        $("#itemamount").html("");

                        for (let k = 0; k < items.length; k++) {
                            $("#itemamount").append('<tr>\
                                <td>'+items[k]+'</td>\
                                <td>'+amounts[k]+'</td>\
                            </tr>');   
                        }

                        $("#itemamount").append('<tr>\
                            <td><b>Total</b></td>\
                            <td><b>'+res.feestructure[0].totalamount+'</b></td>\
                        </tr>')
                   
                    }
            }
            })
        })

        //Change Pending Arrears Balance
        $("#pendingbalancefield").change(function(e){
            e.preventDefault();
            var value = parseInt($(this).val());

            var value2 = parseInt($("#ctermbalancefield").val());

            var total = value + value2;

            $("#totalfeedebtfield").val(total);
        })

        //Change current fee balance 
        $("#ctermbalancefield").change(function(e){
            e.preventDefault();
            var value = parseInt($(this).val());

            var value2 = parseInt($("#pendingbalancefield").val());

            var total = value + value2;

            $("#totalfeedebtfield").val(total);
        })

        //Submit Fee Update Form
        $('#editfeeinformation').submit(function(e){
         removeValidationClasses($('#editfeeinformation'));
         $("#studentinfo").addClass("d-none");
         $("#feestructure").addClass("d-none");
         $("#feepaymentdiv").addClass("d-none");
         e.preventDefault();
         var formdata = new FormData($(this)[0]);
            $.ajax({
                method: 'POST',
                url: '/updateFeeStructure',
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formdata,
                success: function(res) {
                    console.log(res);
                    if (res.status == 400) {
                        showError('pendingbalancefield',res.messages.pendingbalancefield);
                        showError('ctermbalancefield',res.messages.ctermbalancefield);
                    } else if (res.status == 200){
                        $("#response2").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        $("#pendingarrears").text(res.pendingbalance);
                        $("#ctermbalance").text(res.feebalance);
                        $("#feedebt").text(res.ovbalance);
                        $("#pendbalance").text(res.pendingbalance);
                        $("#ctermbal").text(res.feebalance);
                        $("#totalbal").text(res.ovbalance);
                        $("#pendingarrears2").val(res.pendingbalance);
                        $("#pendingtermbalance").val(res.feebalance);
                        $("#totalfeedebt").val(res.ovbalance);
                        $("#pendingbalancefield").val(res.pendingbalance);
                        $("#ctermbalancefield").val(res.feebalance);
                        $("#totalfeedebtfield").val(res.ovbalance);
                        
                        $("#studentinfo").removeClass("d-none");
                        $("#feeinformation").removeClass("d-none");
                        $("#feepaymentdiv").removeClass("d-none");
                    }
            }
            })
        })

        //Show Fee Collection Modal
        $("#feecollectbtn").click(function(e){
            e.preventDefault();
            $("#collectFeeModal").modal("show");
        })

        //Handle payment change
        $("#paymentmethod").change(function(e){
            e.preventDefault();
            
            var payval = $(this).val();

            if (payval === "Cash" ) {
                $("#paymentcode").addClass("d-none");
            } else {
                $("#paymentcode").removeClass("d-none");
            }
        })

        //Submit Fee Payment info 
        $('#receivefeeform').submit(function(e){
         removeValidationClasses($('#receivefeeform'));
        //  $("#studentinfo").addClass("d-none");
        //  $("#feestructure").addClass("d-none");
        //  $("#feepaymentdiv").addClass("d-none");
         e.preventDefault();
         var formdata = new FormData($(this)[0]);

         var confirm = window.confirm(`Are you Sure to Submit the Fee Payment? Make sure the money has Been Deposited`);

        if (confirm) {
            $.ajax({
                method: 'POST',
                url: '/payfees',
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formdata,
                success: function(res) {
                    console.log(res);
                    if (res.status == 400) {
                       showError('paymentmethod',res.messages.paymentmethod);
                       showError('payedfor',res.messages.payedfor);
                       showError('amountreceived',res.messages.amountreceived); 
                    } else if (res.status == 401){
                        showError('transcationcode',res.messages);
                    } else if (res.status == 200) {
                        $("#response").html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert">'+res.messages+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        $("#pendingarrears").text(res.pendingbalances);
                        $("#ctermbalance").text(res.feebalance);
                        $("#feedebt").text(res.ovbalance);
                        $("#pendbalance").text(res.pendingbalances);
                        $("#ctermbal").text(res.feebalance);
                        $("#totalbal").text(res.ovbalance);
                        $("#pendingarrears2").val(res.pendingbalances);
                        $("#pendingtermbalance").val(res.feebalance);
                        $("#totalfeedebt").val(res.ovbalance);
                        $("#pendingbalancefield").val(res.pendingbalances);
                        $("#ctermbalancefield").val(res.feebalance);
                        $("#totalfeedebtfield").val(res.ovbalance);

                        $("#collectFeeModal").modal("hide"); 

                        filename = `${res.student.Fname} ${res.student.Lname} feereceipt`

                        $("#stufeepaymentname").text(res.student.Fname+' '+res.student.Lname);
                        $("#stufeepaymentadmnumber").text(res.student.AdmissionNo);
                        $("#stufeepaymentupinumber").text(res.student.UPI);
                        $("#stufeepaymentcclass").text(res.student.current_class);
                        $("#stufeepaymentcterm").text(res.term);
                        $("#initialpbalance").text(res.initialpendingarrears);
                        $("#initialcbalance").text(res.initialpendingtermbalance);
                        $("#initialovbalance").text(res.initialtotalfeedebt);
                        $("#feeamountreceived").text(res.amount);
                        $("#afterpaypendingbalance").text(res.pendingbalances);
                        $("#afterpaytermbalance").text(res.feebalance);
                        $("#afterpayovbalance").text(res.ovbalance);
                        $("#payreceivedby").text(res.collectedby);
                        $("#paymentdate").text(res.date);

                        $("#receiptdiv").removeClass("d-none");
                    }
            }
            }) 
        }    
        })

        //Close Receipt
        $("#closereceipt").click(function(e){
            e.preventDefault();
            $("#receiptdiv").addClass("d-none");
        })

        //Print Fee Receipt
        $('#printfeepaymentreceipt').click(function(e){
        e.preventDefault();
        $("#innerreceiptdiv").print({
        globalStyles : true,
    })
    })

    //Download Fee Receipt
    window.onload = function(){
        document.getElementById('downloadfeepaymentreceipt').addEventListener('click',()=>{
            const results = this.document.getElementById('innerreceiptdiv');

            var opt = {
                //margin: 0.5,
                filename: `${filename}.pdf`,
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 1 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(results).set(opt).save();
        })
    }

    })
</script>
@endsection