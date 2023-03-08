@extends('layouts.layout')

@section('title','Expenses Record')

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

<!---Expense Edit modal start--->
<div class="modal w3-animate-zoom" id="expenseupdateModal" tabindex="-1" aria-labelledby="expenseupdateModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center">Expense Update Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       <form method="POST" action="#" id="expenseeditform" enctype="multipart/form-data">
        <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
        <input type="number" value="{{ session()->get('LoggedInUser.id') }}" name="uid" id="uid" hidden>
        <input type="number" value="" name="eid" id="eid" hidden>
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
                <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" name="editdateofexpenditure" id="editdateofexpenditure" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
                <div class="form-group">
                    <label for="">Amount Spend</label>
                    <input placeholder="e.g 10000" type="number" name="editamountspend" id="editamountspend" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
                <div class="form-group">
                    <label for="">Expenditure</label>
                    <input placeholder="e.g Maize Purchase" type="text" name="editexpenditure" id="editexpenditure" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>

        <input type="submit" id="editexpenditurebtn" value="EDIT EXPENDITURE" class="btn btn-sm rounded-0 form-control w3-indigo">
       </form>
        </div>
    </div>
    </div>
</div>
<!---Expense Edit modal end--->


<h4>Expenses Recording</h4>
<div>

<div id="regresponse"></div>
<form action="#" method="post" id="expensesrecord" class="p-2">
    <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
    <input type="number" value="{{ session()->get('LoggedInUser.id') }}" name="uid" id="uid" hidden>
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
            <div class="form-group">
                <label for="">Date</label>
                <input type="date" name="dateofexpenditure" id="dateofexpenditure" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
            <div class="form-group">
                <label for="">Amount Spend</label>
                <input placeholder="e.g 10000" type="number" name="amountspend" id="amountspend" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-10 mb-2">
            <div class="form-group">
                <label for="">Expenditure</label>
                <input placeholder="e.g Maize Purchase" type="text" name="expenditure" id="expenditure" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <input type="submit" id="expenditurebtn" value="RECORD EXPENDITURE" class="btn btn-sm rounded-0 form-control w3-green">
</form>
<hr>

<h5 class="text-center">Total Expenditures Recorded <span class="text-danger" id="totalexpenditures"></span> /=</h5>
<hr>
<table class="table" id="tableexpenditures">
<thead>
    <tr>
     <th scope="col">Action</th>
     <th scope="col">Date</th>
     <th scope="col">Amount Spent</th>
     <th scope="col">Expenditure</th>
     <th scope="col">Date Recorded</th>
     <th scope="col">Initially Recorded By</th>
     <th scope="col">Editing Details</th>
    </tr>
</thead>
<tbody id="expenditurestable">
                    
</tbody>
</table>

   
</div>
    
</div>
</div>
</div>
@endsection 
@endif


@section('script')
<script>
$(document).ready(function(){
fetchexpenses();

//set csrf
$.ajaxSetup({
 headers: {
 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  
  //Fetch Expenses
  function fetchexpenses(){
    var sid = "{{ session()->get('schooldetails.id') }}";
    $.ajax({
        method: 'GET',
        url: `/fecthexpenses/${sid}`,
        //dataType: 'jsons',
        success: function(res) {
            //console.log(res);
            $("#totalexpenditures").text(res.expensestotal);

            if (res.expenses.length == 0) {
                $('#expenditurestable').html('');
                $('#expenditurestable').html('<h6 class="text-danger">There are expenses recorded yet.</h6>');
            } else {
                $('#expenditurestable').html('');  

                //<input id="expensecheckbox" type="checkbox" value="'+item.id+'" name="id[]">

            $.each(res.expenses,function(key,item){
                $('#expenditurestable').append('<tr>\
                    <td><button id="expensedelbtn" value="'+item.id+'" class="btn btn-sm w3-red"><i class="fas fa-trash"></i></button> <button id="expenseeditbtn" value="'+item.id+','+item.dateofexpenditure+','+item.amount+','+item.expenditure+'" class="btn btn-sm w3-green"><i class="fas fa-edit"></i></button></td>\
                    <td>'+item.dateofexpenditure+'</td>\
                    <td>'+item.amount+'</td>\
                    <td>'+item.expenditure+'</td>\
                    <td>'+item.created_at+'</button></td>\
                    <td>'+item.recordedby+'</td>\
                    <td>'+(item.updatedby == null ? "Never Been Edited" : `${item.updatedby} on ${item.updated_at}`)+'</td>\
                    </tr>')      
                })

                    $("#tableexpenditures").DataTable().fnDestroy()

                        $('#tableexpenditures').DataTable({
                        ordering: true,
                        paging: true,
                        searching: true
                            });

                    }
                }
                })
            }

            //Submit Expenses form
            $("#expensesrecord").submit(function(e){
            e.preventDefault();
            removeValidationClasses($('#expensesrecord'))
            //$('#regresponse').addClass('d-none');
            $('#expenditurebtn').val('PLEASE WAIT...');
            var formData = new FormData($('#expensesrecord')[0]);

            //var system = $("#educationsystem").val();
                $.ajax({
                method: 'POST',
                url: '/recordexpense',
                contentType: false,
               processData: false,
               data: formData,
               //dataType: 'json',
               success: function(res){
                //console.log(res);
                $('#expenditurebtn').val('RECORD EXPENSE');

                   if (res.status == 400) {
                    //$('#expenditurebtn').val('RECORD EXPENSE');
                    showError('dateofexpenditure', res.messages.dateofexpenditure);
                    showError('amountspend', res.messages.amountspend);
                    showError('expenditure', res.messages.expenditure);
                   } else if(res.status == 200) {
                    removeValidationClasses($('#expensesrecord'))
                    fetchexpenses();
                    $('#expensesrecord')[0].reset();
                    //('#expenditurebtn').val('RECORD EXPENSE');
                    //$('#regresponse').text(res.messages)
                    $('#regresponse').removeClass('d-none');
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   }    
               } 
            });  
            
        })

        //Expense Delete  
        $(document).on('click', '#expensedelbtn',function(e){
         e.preventDefault();
        
        //console.log($(this).val());

        var eid = $(this).val();

        var confirm = window.confirm(`Are you sure you want to delete this Expense? You will not be able to revert this action one executed`);
        
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deleteexpense/${eid}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchexpenses();
                    //$('#regresponse').removeClass('d-none'); 
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
     })

    //Expense Edit Button
    $(document).on('click', '#expenseeditbtn',function(e){
        e.preventDefault();
        var details = $(this).val().split(','); 
        $("#eid").val(details[0]);
        $("#editdateofexpenditure").val(details[1]);
        $("#editamountspend").val(details[2]);
        $("#editexpenditure").val(details[3]);

        $("#expenseupdateModal").modal('show');
        //console.log(details);
    })

     //Submit Expenses form
     $("#expenseeditform").submit(function(e){
        e.preventDefault();
        removeValidationClasses($('#expenseeditform'))
        
        $('#editexpenditurebtn').val('PLEASE WAIT...');
        var formData = new FormData($('#expenseeditform')[0]);

            //var system = $("#educationsystem").val();
        $.ajax({
         method: 'POST',
         url: '/editexpense',
         contentType: false,
         processData: false,
         data: formData,
         success: function(res){
          //console.log(res);
          $('#editexpenditurebtn').val('RECORD EXPENSE');
            if (res.status == 400) {
                showError('editdateofexpenditure', res.messages.editdateofexpenditure);
                showError('editamountspend', res.messages.editamountspend);
                showError('editexpenditure', res.messages.editexpenditure);
            } else if(res.status == 200) {
                removeValidationClasses($('#expenseeditform'))
                fetchexpenses();
                $('#expenseeditform')[0].reset();
                $('#regresponse').removeClass('d-none');
                $("#expenseupdateModal").modal('hide');
                $('#regresponse').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   }    
               } 
            });   
        })

    })
</script>
@endsection