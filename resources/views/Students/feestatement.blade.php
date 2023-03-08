@extends('layouts.layout')

@section('title','Fee Statement')

@section('content')

<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav">
@include('Students.sidebar')
</div>
<div id="main" class="maincontent">
@include('Students.topnav')
<div class="mb-2 p-2" id="btns">
<button class="btn btn-sm w3-green" id="printpdf"><i class="fas fa-file-pdf"></i>&nbsp; PRINT</button>
<button class="btn btn-sm w3-red" id="download"><i class="fas fa-download"></i>&nbsp; DOWNLOAD</button>
</div>
<div id="feepaymentdiv">
<h5 class="text-center w3-green p-2"><span class="">{{ $student['Fname'] }} {{ $student['Lname'] }}</span> Fee Payment History</h5>
<h6 class="text-center text-danger">ADM NO: {{ $student['AdmissionNo'] }}</h6>
<h6 class="text-center text-danger">UPI NO: {{ $student['UPI'] }}</h6>
<h6 class="text-center text-danger">CURRENT CLASS: {{ $student['current_class'] }}</h6>
<h5 class="text-center text-success">Total Fee Payed: <span class="text-danger"><b>{{ $totalpayments }} /=</b></span></h5>
<hr>

@if(count($feepayments) == 0)
    <h6 class="text-center text-danger">{{ $student['Fname'] }} {{ $student['Lname'] }}</span> Does not have any Fee Payment yet</h6>
    @else
<div class="table-responsive">
<table class="table">
            <thead>
            <tr>
                <th scope="col">Date Payed</th>
                <th scope="col">Amount Payed</th>
                <th scope="col">Academic Year</th>
                <th scope="col">Term</th>
                <th scope="col">Payment Method</th>
                <th scope="col">MPESA CODE/Cheque Number</th>
                <th scope="col">Received By</th>
            </tr>
        </thead>
        <tbody class="">
            @foreach($feepayments as $feepayment)
                <tr>
                    <td>{{ $feepayment['created_at'] }}</td>
                    <td>{{ $feepayment['amount'] }}</td>
                    <td>{{ $feepayment['academicyear'] }}</td>
                    <td>{{ $feepayment['term'] }}</td>
                    <td>{{ $feepayment['paymentmethod'] }}</td>
                    @if ($feepayment['paymentmethod'] == "Cash")
                    <td>N/A</td>
                    @elseif ($feepayment['paymentmethod'] == "Bank")
                    <td>{{ $feepayment['Cheque_number'] }}</td>
                    @else
                    <td>{{ $feepayment['MPESA_Code'] }}</td>
                    @endif
                    <td>{{ $feepayment['Collected_By'] }}</td>
                </tr>
            @endforeach
        </tbody>
        </table>
        </div>
        @endif
        </div>

  </div>  
</div>
</div>
</div>
@endsection 


@section('script')
<script>
function preview(){
        frame.src=URL.createObjectURL(event.target.files[0]);
        }
</script>
<script>
$(document).ready(function(){
  //Print a PDF
    var filename = "{{ $student['Fname'] }} {{ $student['Lname'] }} fee information"

  $('#printpdf').click(function(e){
        e.preventDefault();
        $("#feepaymentdiv").print({
        globalStyles : true,
    })
    })

    //Download
    window.onload = function(){
        document.getElementById('download').addEventListener('click',()=>{
            const results = this.document.getElementById('feepaymentdiv');

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