@extends('layouts.layout')

@section('title','DashBoard')

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
<!--Create fee structure modal start--->
<div id="createFeetrstructureModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">Create Fee Structure</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="subregdiv2"></div>
      <h6 class="text-center"><button id="addmodulebtn" class="btn btn-danger btn-sm border-radius-25"><i class="fas fa-plus"></i>&nbsp; Add Module</button></h6>
        <form id="feestructurecreateform" class="m-3" action="#" method="post">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-10">
            <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
            <input type="number" value="{{ session()->get('LoggedInUser.id') }}" name="uid" id="uid" hidden>
            <div class="form-group mb-2">
                <label for="">Select Term</label>
                <select name="term" id="term" class="form-control">
                    <option value="">Select Term</option>
                    <option value="TERM ONE">TERM ONE</option>
                    <option value="TERM TWO">TERM TWO</option>
                    <option value="TERM THREE">TERM THREE</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div id="feemodules">
            <div id="feerow" class="row p-2">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for=""><b>Enter Module</b></label>
                        <input type="text" name="module" id="module" placeholder="e.g Transport Fee" class="form-control module">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group">
                        <label for=""><b>Enter Amount</b></label>
                        <input type="text" name="amount" id="amount" placeholder="e.g 2500" class="form-control amount">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <h5 class="text-danger text-center" style="margin-top: 5px; margin-right: 0px;"><button id="hidemodule" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></h5>
            </div>
            </div>

            </div>

            <div class="col-lg-6 col-md-6 col-sm-10">
            <table id="classestable" class="table border border-primary mb-1">
                <h6 class="text-success">Please Select The Classes That This Fee Structure Will Apply To.</h6>
                    <thead>
                    <tr>
                      <th scope="col">Select</th>
                      <th scope="col">Class</th> 
                    </tr>
                    </thead>
                    <tbody id="classes">
            
                    </tbody>
                </table>
                <h6 id="missingclassalert" class="text-danger text-center d-none"></h6>   

            </div>
            <div class="form-group mt-3 d-grid">
            <input id="submitfeeform" type="submit" class="btn btn-sm btn-block btn-rounded-0 btn-info" value="CREATE FEE STRUCTURE">
        </div>

        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Create fee structure modal end--->


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

        <div class="justify-content-center align-items-center">
        <button id="downloadpdf" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i>&nbsp; DOWNLOAD</button>
        <button id="printpdf" class="btn w3-green btn-sm"><i class="fas fa-print"></i>&nbsp; PRINT</button>
        </div>

      </div>
    </div>
  </div>
</div>
<!--View fee structure modal end--->


<!---Edit fee structure modal end--->
<div id="updateFeetrstructureModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">Update Fee Structure</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="subregdiv4"></div>
      <h6 class="text-center"><button id="addmodulebtn2" class="btn btn-danger btn-sm border-radius-25"><i class="fas fa-plus"></i>&nbsp; Add Module</button></h6>
        <form id="feestructureupdateform" class="m-3" action="#" method="post">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-10">
            <input type="number" name="fid" id="fid" hidden>
            <input type="number" value="{{ session()->get('schooldetails.id') }}" name="sid" id="sid" hidden>
            <input type="number" value="{{ session()->get('LoggedInUser.id') }}" name="uid" id="uid" hidden>
            <input type="number" name="cid" id="cid" hidden>
            <div class="form-group mb-2">
                <input readonly type="text" name="editclassname" id="editclassname" class="form-control">
            </div>
            <div class="form-group mb-2">
                <select readonly name="term" id="term2" class="form-control">
                    <option id="editterm"></option>
                    <option value="TERM ONE">TERM ONE</option>
                    <option value="TERM TWO">TERM TWO</option>
                    <option value="TERM THREE">TERM THREE</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div id="feemodules2">
            <div id="feerow2" class="row p-2">
                
            </div>
            </div>

            </div>

            <div class="form-group mt-3 d-grid">
            <input id="submitfeeupdateform" type="submit" class="btn btn-sm btn-block btn-rounded-0 btn-success" value="UPDATE FEE STRUCTURE">
        </div>

        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!---Edit  fee structure modal end--->

<div class="loader d-none"></div>
<div class="row justify-content-center">
<div id="subregdiv"></div>
    <div class="col-lg-10 col-md-10 col-sm-12">
    <button class="btn-sm w3-green" data-bs-toggle="modal" data-bs-target="#createFeetrstructureModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp;CREATE FEE STRUCTURE</button>
    <div id="actionbtns" class="">
            <button id="viewbtn" class="btn btn-sm btn-info float-end m-1"><i class="fas fa-eye"></i>&nbsp;View</button>
            <button id="editbtn" class="btn btn-sm btn-warning float-end m-1"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
            <button id="delbtn" class="btn btn-sm btn-danger float-end m-1"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button> 
    </div> 

    <table id="feestructurestable" class="table">
        <thead>
            <tr>
            <th scope="col">Select</th>
            <th scope="col">Term</th> 
            <th scope="col">Classes</th>
            <th scope="col">Modules</th>
            <th scope="col">Amounts</th>
            <th scope="col">Total</th>
            <th scope="col">Created By</th>
            </tr>
        </thead>
        <tbody id="feestructures">
            
        </tbody>
        </table>
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

        var filename = "";
        fecthclasses();
        fetchfeestructures();

        //Dynamically change the color for amount input field
        $(document).on('change', '#amount',function(e){
            e.preventDefault();
            var val = $(this).val();
            if (val !== "") {
                $(this).css({'background':'#00cc99',});
            } else {
                $(this).css('background','white');
            }
        })

        //Dynamically change color for module
        $(document).on('change', '#module',function(e){
            e.preventDefault();
            var val = $(this).val();
            if (val !== "") {
                $(this).css({'background':'lightsalmon',});
            } else {
                $(this).css('background','white');
            }
        })

        //Show Action buttons
        $(document).on('change', '.checkboxid',function(e){
            e.preventDefault();
            var id = $(this).val();
            $('#actionbtns').removeClass('d-none');
        })

        $("#hidemodule").click(function(e){
            e.preventDefault();
        })

        $("#addmodulebtn").click(function(){
            var html = '<div id="feerow" class="row p-2 w3-animate-top"><div class="col-lg-6"><div class="form-group"><label for=""><b>Enter Module</b></label><input type="text" name="module" id="module" placeholder="e.g Transport Fee" class="form-control module"><div class="invalid-feedback"></div></div></div><div class="col-lg-6"><div class="form-group"><label for=""><b>Enter Amount</b></label><input type="text" name="amount" id="amount" placeholder="e.g 2500" class="form-control amount"><div class="invalid-feedback"></div></div></div><h5 class="text-danger text-center" style="margin-top: 5px; margin-right: 0px;"><button id="hidemodule" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></h5></div>';
            $("#feemodules").append(html);
        })

        //function to fetchclasses
        function fecthclasses(){
            var sid = {{ session()->get('schooldetails.id') }}
            $.ajax({
                method: 'GET',
                url: `/fetchclasses/${sid}`,
                success: function(res){
                   // console.log(res)
                    if (res.classes.length == 0) {
                        $('#classes').html('<h5 class="text-danger">There are no classes registered yet. Register classes to continue with Fee structure Generation</h5>')
                    } else {
                        $('#classes').html('')
                        $.each(res.classes, function(key,item){
                            $('#classes').append('<tr>\
                            <td><input value="'+item.id+'" type="checkbox" name="" id="classselectbox"></td>\
                            <td>'+item.class+' '+(item.stream == null ? "" : item.stream)+'</td>\
                        </tr>');
                        })

                        $("#classestable").DataTable().fnDestroy()

                        $('#classestable').DataTable({
                        ordering: false,
                        paging: true,
                        searching: true
                         });
                    }
                }
            });
        }
        //Create Fee structure
        $('#feestructurecreateform').submit(function(e){
          e.preventDefault();
          $('#missingclassalert').addClass('d-none');
          $('#missingclassalert').text('');
          removeValidationClasses($('#feestructurecreateform'))
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#feestructurecreateform')[0]);
          
          var classes = [];
          var modules = [];
          var amounts = [];
            $('#classselectbox:checked').each(function(i){
                classes[i] = $(this).val()
            })  

            $('.module').each(function(i){
                modules[i] = $(this).val()
            })

            $('.amount').each(function(i){
                amounts[i] = $(this).val()
            })

            if (modules.length == 0) {
                alert("You must include some fee modules");
            } else if (amounts.length == 0) {
                alert("You must include the fee module amounts");
            } else {
            formdata.append('classes', classes);
            formdata.append('modules', modules);
            formdata.append('amounts', amounts);

          $.ajax({
                method: 'POST',
                url: '/registerfeestructure',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){ 
               $('.loader').addClass('d-none')
                //console.log(res);
                   if (res.status == 200) {
                        removeValidationClasses($('#feestructurecreateform'));
                        $('#missingclassalert').addClass('d-none');
                        fetchfeestructures();
                        //fetchSubjects();
                       $('#feestructurecreateform')[0].reset();
                       $("#createFeetrstructureModal").modal('hide');
                       $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                   } else if(res.status == 400){
                    //$('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages.subjects+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')  
                    showError('term', res.messages.term);
                    showError('module', res.messages.modules);
                    showError('amount', res.messages.amounts);
                    $('#missingclassalert').removeClass('d-none');
                    $('#missingclassalert').text(res.messages.classes);
                }
                    else if(res.status == 401){
                        $('#subregdiv2').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   

                        $('.module').each(function(i){
                            if ($(this).val() == "") {
                                showError($(this), 'This value must be provided');
                            }
                        })

                        $('.amount').each(function(i){
                            if ($(this).val() == "") {
                                showError($(this), 'This value must be provided');
                            }
                        })                        
                    
                    }  
                } 
            });
        }
      })

    //Update Fee Structure
    $('#feestructureupdateform').submit(function(e){
          e.preventDefault();
          $('#missingclassalert').addClass('d-none');
          $('#missingclassalert').text('');
          removeValidationClasses($('#feestructureupdateform'))
          $('.loader').removeClass('d-none')
          var formdata = new FormData($('#feestructureupdateform')[0]);
          $.ajax({
                method: 'POST',
                url: '/updatefeestructure',
                contentType: false,
               processData: false,
               data: formdata,
               //dataType: 'json',
               success: function(res){ 
               $('.loader').addClass('d-none')
                    if (res.status == 401) {
                        $('#subregdiv4').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')     
                    } else if(res.status == 200) {
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')      
                        $('#updateFeetrstructureModal').modal("hide");

                        $("#feerow2").html("");

                        $('#feestructureupdateform')[0].reset();
                        fetchfeestructures();
                    }  
                } 
            });
      })


      //Fetch Fee Structures
      function fetchfeestructures(){
            var sid = {{ session()->get('schooldetails.id') }}
            $.ajax({
                method: 'GET',
                url: `/fetchfeestructures/${sid}`,
                success: function(res){
                    if (res.feestructures.length == 0) {
                        $('#feestructures').html('<h5 class="text-danger">There are no classes registered yet. Register classes to continue with Fee structure Generation</h5>')
                    } else {
                        $('#feestructures').html('')
                        $.each(res.feestructures, function(key,item){
                            //var html = '<div id="modules" class="text-danger"></div>';
                            for (let index = 0; index < item.modules.split(',').length; index++) {
                                const element = item.modules.split(',')[index];
                               // $('#modules').append('<p>'+element+'</p>');
                            }
                            // <td>'for (let i = 0; i < item.modules.split(',').length; i++) {
                            //     const element = item.modules.split(',')[i];
                            //     '<h6>'+element+'</h6>' 
                            // }'</td>\
                            $('#feestructures').append('<tr>\
                            <td><input value="'+item.id+'" type="checkbox" class="checkboxid" name="" id="feeselectbox"></td>\
                            <td>'+item.Term+'</td>\
                            <td>'+(item.classnames)+'</td>\
                            <td id="modules" class="text-danger">'+item.modules.split(',')+'</td>\
                            <td>'+item.amounts+'</td>\
                            <td>'+item.totalamount+'</td>\
                            <td>'+item.createdby+','+item.crole+'</td>\
                        </tr>');
                        })

                        $("#feestructurestable").DataTable().fnDestroy()

                        $('#feestructurestable').DataTable({
                            ordering: true,
                            paging: true,
                            searching: true
                         });
                    }
                }
                });
            }

    //view Fee structure
    $(document).on('click', '#viewbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#feeselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a class to view the fee structure')
        } else if (ids.length > 1) {
            alert('You can only view the fee structure for one class.')
        } else {
            $.ajax({
                method: 'GET',
                url: `/fetchfeestructure/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                //console.log(res)
                filename = `${res.feestructure.classnames}`;

                $("#fclass").text(res.feestructure.classnames)
                $("#viewFeetrstructureModal").modal('show')   
                
                var items = res.feestructure.modules.split(",");

                var amounts = res.feestructure.amounts.split(",");

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
                    <td><b>'+res.feestructure.totalamount+'</b></td>\
                </tr>')

                }
                })  
        }    
     })
     
     //Delete a Fee Structure
     $(document).on('click', '#delbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#feeselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })

        if (ids.length < 1) {
            alert("You must select at least one fee structure to delete")
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this fee structure(s)`);
            if (confirm) {
                $.ajax({
                method: 'GET',
                url: `/deletefeestructure/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchfeestructures();
                    $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#subregdiv').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>Sorry! Something went wrong.Please try again later</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                })
            }
        }
    })
        

     //Update Fee Structure editbtn
     $(document).on('click', '#editbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#feeselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select a class to edit the fee structure')
        } else if (ids.length > 1) {
            alert('You can only edit the fee structure for one class.')
        } else {
            $.ajax({
                method: 'GET',
                url: `/fetchfeestructure/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                    $("#editterm").val(res.feestructure.Term);
                    $("#editterm").text(res.feestructure.Term);
                    $("#fid").val(res.feestructure.id);
                    $("#editclassname").val(res.feestructure.classnames);
                    $("#cid").val(res.feestructure.classes);

                    var modules = res.feestructure.modules.split(",");
                    var amounts = res.feestructure.amounts.split(","); 

                    $("#feerow2").html("");
                    
                    for (let k = 0; k < modules.length; k++) {
                        //const element = array[k]; '+modules[k]+' '+amounts[k]+'
                        var html = '<div id="'+amounts[k]+'" class="col-lg-6"><div class="form-group"><label for=""><b>Module</b></label><input type="text" sval="'+amounts[k]+'" value="'+modules[k]+'" name="editmodule[]" id="editmodule" placeholder="e.g Transport Fee" class="form-control module"><div class="invalid-feedback"></div></div></div> <div id="'+amounts[k]+'" class="col-lg-6"><div class="form-group"><label for=""><b>Amount</b></label><input type="nummber" sval="'+amounts[k]+'" value="'+amounts[k]+'" name="editamount[]" id="editamount" placeholder="e.g 2500" class="form-control amount"><div class="invalid-feedback"></div></div></div><h5 class="text-danger text-center" style="margin-top: 5px; margin-right: 0px;"><button value="'+amounts[k]+'" id="removemodule" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></h5>';

                        $("#feerow2").append(html);
                    }

                    $("#updateFeetrstructureModal").modal("show");    
                }
                })  
        }    
     })

     //Add Fee Item to Edit Form
     $(document).on('click', '#addmodulebtn2',function(e){
        e.preventDefault();
        var html = '<div id="feerow2" class="row p-2 w3-animate-top"><div class="col-lg-6"><div class="form-group"><label for=""><b>Enter Module</b></label><input type="text" name="editmodule[]" id="editmodule" placeholder="e.g Transport Fee" class="form-control module"><div class="invalid-feedback"></div></div></div><div class="col-lg-6"><div class="form-group"><label for=""><b>Enter Amount</b></label><input type="text" name="editamount[]" id="editamount" placeholder="e.g 2500" class="form-control amount"><div class="invalid-feedback"></div></div></div></div>';
            $("#feemodules2").append(html);
     })

     //Remove fee module 
     $(document).on('click', '#removemodule',function(e){
        e.preventDefault();
        var val = $(this).val();
        $(this).addClass('d-none');
        $('#feestructureupdateform').find(`input[sval='${val}']`).each(function(i){
                $(this).prop("disabled", !$(this).prop("disabled"));
                $(this).addClass('d-none')
        })

            $('#feestructureupdateform').find(`div[id='${val}']`).each(function(i){
                $(this).addClass('d-none');
            })
     })

     //Print Feestructure File
      $('#printpdf').click(function(e){
            e.preventDefault();
            $("#feestucturediv").print({
                globalStyles : true,
            })
        })

      //Download Fee Structure
      window.onload = function(){
        document.getElementById('downloadpdf').addEventListener('click',()=>{
            const results = this.document.getElementById('feestucturediv');

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