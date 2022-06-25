@extends('layouts.layout')

@section('title','DashBoard')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">
@include('adminFiles.motto')
<div class="main">
<div id="sidenavigation" class="sidenav">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
<div class="loader d-none"></div>
@include('adminFiles.topnav')
<div class="row justify-content-center">
    <div id="feestructurediv" class="col-lg-5 col-md-6 col-sm-10">
    <h5 class="text-center text-success">CREATE A FEE STRUCTURE</h5>
    <h6 class="text-center"><button id="addmodulebtn" class="btn btn-danger btn-sm border-radius-25"><i class="fas fa-plus"></i>&nbsp; Add Module</button></h6>
        <form id="feestructurecreateform" class="m-3" action="#" method="post">
            <div id="subregdiv"></div>  
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

            <table id="classestable" class="table border border-primary mb-1">
                <h6 class="text-success"><b>Please Select The Classes That This Fee Structure Will Apply To.</b></h6>
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

        <div class="form-group mt-3 d-grid">
            <input id="submitfeeform" type="submit" class="btn btn-sm btn-block btn-rounded-0 btn-info" value="CREATE FEE STRUCTURE">
        </div>
        </form>
    </div>



    <div class="col-lg-7 col-md-6 col-sm-10">

    <div id="actionbtns" class="d-none">
            <button id="viewbtn" class="btn btn-sm btn-info float-end m-1"><i class="fas fa-eye"></i>&nbsp;View</button>
            <button id="teachereditbtn" class="btn btn-sm btn-warning float-end m-1"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
            <button id="teacherdelbtn" class="btn btn-sm btn-danger float-end m-1"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button> 
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

        //Hide some module hidemodule
        $(document).on('click', '#hidemodule',function(e){
            e.preventDefault();
            // var id = $(this).val();
            // $('#actionbtns').removeClass('d-none');
        })

        //Show Action buttons
        $(document).on('change', '.checkboxid',function(e){
            e.preventDefault();
            var id = $(this).val();
            $('#actionbtns').removeClass('d-none');
        })

        fecthclasses();
        fetchfeestructures();

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
                    console.log(res)
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

                        // $("#classestable").DataTable().fnDestroy()

                        // $('#classestable').DataTable({
                        // ordering: false,
                        // paging: false,
                        // searching: true
                        //  });
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
                console.log(res);
                   if (res.status == 200) {
                        removeValidationClasses($('#feestructurecreateform'));
                        $('#missingclassalert').addClass('d-none');
                        fetchfeestructures();
                        fetchSubjects();
                       $('#feestructurecreateform')[0].reset();
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
                        $('#subregdiv').html('<div class="alert alert-danger alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div')   
                        
                        $('.module').each(function(i){
                            //modules[i] = $(this).val()
                            if ($(this).val() == "") {
                                showError($(this), 'This value must be provided');
                            }
                        })

                        $('.amount').each(function(i){
                            //amounts[i] = $(this).val()
                            if ($(this).val() == "") {
                                showError($(this), 'This value must be provided');
                            }
                        })                        
                    
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

    })
</script>
@endsection