@extends('layouts.layout')

@section('title','Financial Report')

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
<h6 class="text-danger">Financial Reports Generator</h6>

<!--Fee Payment Financial Report Start--->
<div id="feereport" class="w3-animate-left d-none">
    <button id="downloadfeereport" class="btn w3-red btn-sm mb-1"><i class="fas fa-file-pdf"></i>&nbsp;DOWNLOAD</button>
    <button id="printfeereport" class="btn w3-green btn-sm mb-1"><i class="fas fa-print"></i>&nbsp;PRINT</button>
    <button id="closefeereport" class="btn w3-red float-end btn-sm">Close</button>

    <div id="innerfeereport">
        <h4 class="text-center w3-green p-2 mt-2">{{ session()->get('schooldetails.name') }}</h4>
        <h5 class="text-center">FEE PAYMENT FINANCIAL REPORT</h5>
        <h6 class="text-center">Fee Payment FROM <span class="text-danger" id="from"></span> TO <span class="text-danger" id="to"></span></h6>
        <h5 class="text-center">Total Fee Collected : <span id="totalfeecollected" class="text-danger"></span>/=</h5>
        <hr>

        <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Date Payed</th>
                <th scope="col">Amount Payed</th>
                <th scope="col">Student Adm/UPI</th>
                <th scope="col">Academic Year</th>
                <th scope="col">Term</th>
                <th scope="col">Payment Method</th>
                <th scope="col">MPESA CODE/Cheque Number</th>
                <th scope="col">Received By</th>
            </tr>
        </thead>
        <tbody id="feepaybody">
        
        </tbody>
        </table>
        </div>
    </div>
</div>
<!--Fee Payment Financial Report End--->

<!--Expenditure Financial Report Start--->
<div id="expenditurereport" class="w3-animate-left d-none">
    <button id="downloadexpenditurereport" class="btn w3-red btn-sm mb-1"><i class="fas fa-file-pdf"></i>&nbsp;DOWNLOAD</button>
    <button id="printexpenditurereport" class="btn w3-green btn-sm mb-1"><i class="fas fa-print"></i>&nbsp;PRINT</button>
    <button id="closeexpenditurereport" class="btn w3-red float-end btn-sm">Close</button>

    <div id="innerexpenditurereport">
        <h4 class="text-center w3-green p-2 mt-2">{{ session()->get('schooldetails.name') }}</h4>
        <h5 class="text-center">EXPENDITURE FINANCIAL REPORT</h5>
        <h6 class="text-center">EXPENDITURE FROM <span class="text-danger" id="from1"></span> TO <span class="text-danger" id="to1"></span></h6>
        <h5 class="text-center">Total Expenditure : <span id="totalexpenditure" class="text-danger"></span>/=</h5>
        <hr>
        <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Date Spend</th>
                <th scope="col">Amount Spent</th>
                <th scope="col">Expenditure</th>
                <th scope="col">Date Recorded</th>
                <th scope="col">Initially Recorded By</th>
                <th scope="col">Editing Details</th>
            </tr>
        </thead>
        <tbody id="expenditurebody">
        
        </tbody>
        </table>
        </div>
    </div>
</div>
<!--Expenditure Financial Report End--->

<div class="row p-2 align-items-center justify-content-center">
    <div id="feereportdiv" class="col-lg-6 col-md-6 col-sm-12 w3-animate-right">
    <h6 class="text-center"><button id="feepaymentreports" class="btn btn-sm w3-indigo">Activate Fee Payment Report</button></h6>
        <form action="#" method="post" id="feepaymentform">
        <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
            <div class="form-group mb-2">
                <label for=""><b>Select Period</b></label>
                <select disabled sval2='feefield' name="feereportselect" id="feereportselect" class="form-control">
                 <option value="">Select</option>
                 <option value="ALL">All</option>
                 <option value="specify">Let me Specify</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-12">
                  <div class="form-group mb-2">
                    <label for=""><b>From Date</b></label>
                    <input disabled sval2='feefield' type="date" name="feestartdate" id="feestartdate" class="form-control">
                  </div>
                  <div class="invalid-feedback"></div>
                </div>

                <div class="col-lg-6 col-md-8 col-sm-12">
                 <div class="form-group mb-2">
                    <label for=""><b>To Date</b></label>
                    <input disabled sval2='feefield' type="date" name="feetodate" id="feetodate" class="form-control">
                 </div>
                 <div class="invalid-feedback"></div>   
                </div>
            </div>

            <button disabled sval2='feefield' type="submit" class="btn btn-sm w3-indigo form-control">GENERATE FEE PAYMENT REPORT</button>
            <!-- <input disabled  type="submit" id="generatefeereportbtn" value="GENERATE FEE PAYMENT REPORT" class="btn btn-sm w3-indigo form-control"> -->
        </form>
    </div>

    <div id="expensereportdiv" class="col-lg-6 col-md-6 col-sm-12 w3-animate-left">
    <h6 class="text-center"><button id="expensesreports" class="btn btn-sm w3-green">Activate Expenditure Report</button></h6>
        <form action="#" method="post" id="expenseform">
        <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
            <div class="form-group mb-2">
                <label for=""><b>Select Period</b></label>
                <select disabled sval2='expensefield' name="expensereportselect" id="expensereportselect" class="form-control">
                 <option value="">Select</option>
                 <option value="ALL">All</option>
                 <option value="specify">Let me Specify</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-12">
                  <div class="form-group mb-2">
                    <label for=""><b>From Date</b></label>
                    <input disabled sval2='expensefield' type="date" name="expensestartdate" id="expensestartdate" class="form-control">
                 <div class="invalid-feedback"></div>  
                </div>
                </div>

                <div class="col-lg-6 col-md-8 col-sm-12">
                 <div class="form-group mb-2">
                    <label for=""><b>To Date</b></label>
                    <input disabled sval2='expensefield' type="date" name="expensetodate" id="expensetodate" class="form-control">
                 </div> 
                 <div class="invalid-feedback"></div>  
                </div>
            </div>

            <button disabled sval2='expensefield' type="submit" class="btn btn-sm w3-green form-control">GENERATE EXPENDITURE REPORT</button>
            <!-- <input disabled sval2='expensefield' type="submit" id="generateexpenditurereportbtn" value="GENERATE EXPENDITURE REPORT" class="btn btn-sm w3-green form-control"> -->
        </form>
    </div>
</div>
<hr>

</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
$(document).ready(function(){
//set csrf
$.ajaxSetup({
 headers: {
 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$("#feepaymentreports").click(function(e){
    e.preventDefault();

    $('#feepaymentform').find(`input[sval2='feefield']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })

    $('#feepaymentform').find(`select[sval2='feefield']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })

    $('#feepaymentform').find(`button[sval2='feefield']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })

    // $('#expenseform').find(`input[sval2='expensefield']`).each(function(i){
    //     $(this).prop("disabled", !$(this).prop("disabled"));
    // })

    // $('#expenseform').find(`select[sval2='expensefield']`).each(function(i){
    //     $(this).prop("disabled", !$(this).prop("disabled"));
    // })

    $("#feereportdiv").removeClass('d-none');
    $("#expensereportdiv").removeClass('d-none');

})

$("#expensesreports").click(function(e){
    e.preventDefault();

    $('#expenseform').find(`input[sval2='expensefield']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })

    $('#expenseform').find(`select[sval2='expensefield']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })

    $('#expenseform').find(`button[sval2='expensefield']`).each(function(i){
        $(this).prop("disabled", !$(this).prop("disabled"));
    })

    $("#feereportdiv").removeClass('d-none');
    $("#expensereportdiv").removeClass('d-none');
})

//Fee Payment Report Generator
$("#feereportselect").change(function(e){
    e.preventDefault();

    var val = $(this).val()

    if (val == "ALL") {
        $('#feepaymentform').find(`input[sval2='feefield']`).each(function(i){
            //$(this).prop("disabled", !$(this).prop("disabled"));
            $(this).prop("disabled",true);
        })
    } else {
        $('#feepaymentform').find(`input[sval2='feefield']`).each(function(i){
            $(this).prop("disabled",false);
        })
    }   
})

//Expenditure Report Genearator
$("#expensereportselect").change(function(e){
    e.preventDefault();

    var val = $(this).val()

    if (val == "ALL") {
        $('#expenseform').find(`input[sval2='expensefield']`).each(function(i){
            //$(this).prop("disabled", !$(this).prop("disabled"));
            $(this).prop("disabled",true);
        })
    } else {
        $('#expenseform').find(`input[sval2='expensefield']`).each(function(i){
            $(this).prop("disabled",false);
        })
    }   
})

//Generate Fee Payment Report Form Submit
$("#feepaymentform").submit(function(e){
    e.preventDefault();
    removeValidationClasses($('#feepaymentform'))
    var formdata = new FormData($(this)[0]);

        $.ajax({
            method: 'POST',
            url: '/feepaymentreport',
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            success: function(res) {
                console.log(res);
                if (res.status == 400) {
                    showError('feereportselect',res.messages.feereportselect);
                } else if (res.status == 401) {
                    showError('feestartdate',res.messages);
                } else if (res.status == 402) {
                    showError('feetodate',res.messages);
                } else if (res.status == 200) {
                    $("#expenditurereport").addClass("d-none");
                    $("#from").text(res.from);
                    $("#to").text(res.to);
                    $("#totalfeecollected").text(res.totalpayed);
                    $("#feepaybody").html('');

                    if (res.feepayments.length == 0) {
                        $("#feepaybody").html('<h6 class="text-danger">No Fee Payment Matching the Defined Period</h6>');
                    } else {
                        $.each(res.feepayments, function(key,item){
                        $('#feepaybody').append('<tr>\
                        <td>'+item.created_at+'</td>\
                        <td>'+item.amountpayed+'</td>\
                        <td>'+item.AdmorUPI+'</td>\
                        <td>'+item.academicyear+'</td>\
                        <td>'+item.term+'</td>\
                        <td>'+item.paymentmethod+'</td>\
                        <td>'+(item.paymentmethod === "Cash" ? "<b class=''>N/A</b>" : item.paymentmethod === "MPESA" ? item.MPESA_Code : item.Cheque_number )+'</td>\
                        <td>'+item.Collected_By+'</td>\
                    </tr>');
                    });  
                    }

                   
                    $("#feereport").removeClass("d-none");
                }
            }
         })
})

//Generate Expense Report Form Submit
$("#expenseform").submit(function(e){
    e.preventDefault();
    removeValidationClasses($('#expenseform'))
    var formdata = new FormData($(this)[0]);

        $.ajax({
            method: 'POST',
            url: '/expenditurereport',
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            success: function(res) {
                console.log(res);
                if (res.status == 400) {
                    showError('expensereportselect',res.messages.expensereportselect);
                } else if (res.status == 401) {
                    showError('expensestartdate',res.messages);
                } else if (res.status == 402) {
                    showError('expensetodate',res.messages);
                } else if (res.status == 200) {
                    $("#feereport").addClass("d-none");
                    $("#from1").text(res.from);
                    $("#to1").text(res.to);
                    $("#totalexpenditure").text(res.totalpayed);
                    $("#expenditurebody").html('');

                    if (res.expenses.length == 0) {
                        $("#expenditurebody").html('<h6 class="text-danger">No Expenditure Matching the Defined Period</h6>');
                    } else {
                        $.each(res.expenses,function(key,item){
                        $('#expenditurebody').append('<tr>\
                            <td>'+item.dateofexpenditure+'</td>\
                            <td>'+item.amount+'</td>\
                            <td>'+item.expenditure+'</td>\
                            <td>'+item.created_at+'</button></td>\
                            <td>'+item.recordedby+'</td>\
                            <td>'+(item.updatedby == null ? "Never Been Edited" : `${item.updatedby} on ${item.updated_at}`)+'</td>\
                            </tr>')      
                        })  
                    }

                   
                    $("#expenditurereport").removeClass("d-none");
                }
            }
         })
})

//Close Fee Report
$("#closefeereport").click(function(e){
    e.preventDefault();

    $("#feereport").addClass("d-none");
})

//Close Expenditure Report 
$("#closeexpenditurereport").click(function(e){
    e.preventDefault();

    $("#expenditurereport").addClass("d-none");
})

 //Print Fee Receipt
 $('#printfeereport').click(function(e){
        e.preventDefault();
        $("#innerfeereport").print({
        globalStyles : true,
    })
    })

//Print Expenditures Report
$('#printexpenditurereport').click(function(e){
        e.preventDefault();
        $("#innerexpenditurereport").print({
        globalStyles : true,
    })
})

    //Download Fee Receipt
    window.onload = function(){
        document.getElementById('downloadfeereport').addEventListener('click',()=>{
            const results = this.document.getElementById('innerfeereport');

            var opt = {
                //margin: 0.5,
                filename: `feepayment_financial_report.pdf`,
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 1 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(results).set(opt).save();
        })
    }

    //Download Expenditure Report
    window.onload = function(){
        document.getElementById('downloadexpenditurereport').addEventListener('click',()=>{
            const results = this.document.getElementById('innerexpenditurereport');

            var opt = {
                //margin: 0.5,
                filename: `expenditure_financial_report.pdf`,
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