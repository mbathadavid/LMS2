@extends('layouts.layout')

@section('title','Domitories/Hostels')

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
<h5>Domitories/Hostels</h5>
<hr>
<!----Class edit Modal start--->
<div id="hosteleditModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">HOSTEL/DOMITORY EDITING</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="hosteleditform">
            <input type="number" name="edithostelid" id="edithostelid" hidden>
            <div class="form-group mb-2">
                <label for=""><b>Hostel Name</b></label>
                <input type="text" name="edithostelname" id="edithostelname" class="form-control">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-3 d-grid">
                <input type="submit" class="btn btn-info" id="submiteditclass" value="EDIT HOSTEL">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!----Class edit Modal start--->

<!----Set Current Term Modal start--->
<div id="currentTermmodal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">SET CURRENT TERM.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="settermform">
            <input hidden type="number" value="{{session()->get('schooldetails.id')}}" name="sid" id="sid">
            <input hidden type="text" name="settermclassid" id="settermclassid">
                <div class="form-group mb-3">
                <label for=""><h4>Select Term<sup class="text-danger"><b></b></sup></h4></label>
                <select name="currentterm" id="currentterm" class="form-control">
                    <option value="">Select The Current Term</option>
                    <option value="TERM ONE">TERM ONE</option>
                    <option value="TERM TWO">TERM TWO</option>
                    <option value="TERM THREE">TERM THREE</option>
                </select>
                <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mb-3 d-grid">
                    <input type="submit" class="btn btn-warning" id="submitcurrentterm" value="SET CURRENT TERM">
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!----Set Current Term Modal start--->

<div class="row justify-content-center align-items-center">
<div class="col-lg-5 col-md-4 col-sm-12 border border-2 border-danger">
    <form action="#" method="POST" id="registerhostel">
        <div id="classregres"></div>
        <input type="number" value="{{session()->get('schooldetails.id')}}" name="sid" id="sid" hidden>

        <div class="form-group mb-3">
            <label for="">Enter Name of the Hostel/Domitory</label>
            <input type="text" placeholder="Name of the hostel" name="hostel" id="hostel" class="form-control">
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group mb-3 d-grid">
            <input type="submit" class="btn btn-info" id="submitclass" value="ADD HOSTEL">
        </div>
    </form>
    </div>

    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="table-responsive">
                <div id="actionbtns" class="mb-2">
                    <button id="hosteldeletebtn" class="btn-sm btn-danger float-end" type="button"><i class="fas fa-trash"></i>&nbsp;Delete</button>
                    <button id="hosteleditbtn" class="btn-sm btn-info float-end" type="button"><i class="fas fa-edit"></i>&nbsp;Edit</button>
                </div>
            <table id="hostelstable" class="table">
                <thead>
                <tr>
                    <th scope="col">Select</th>
                    <th scope="col">Hostel</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            </table>
        </div>
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
        fecthhostels();

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

    //Register hostels            
        $("#registerhostel").submit(function(e){
            e.preventDefault();
            removeValidationClasses($(this))
            $('#classregres').html('')
            $("#submitclass").val('PLEASE WAIT...');
            $.ajax({
                url: '{{ route('hostel.register') }}',
               method: 'post',
               data: $(this).serialize(),
               dataType: 'json',
               success: function(res){
                $("#submitclass").val('ADD HOSTEL');
                if (res.status == 400) {
                    showError('hostel', res.messages.hostel);
                } else if (res.status == "available") {
                    //$('#classregres').removeClass('d-none')
                    $('#classregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>') 
                } else {
                    fecthhostels();
                    $('#registerhostel')[0].reset();
                    //$('#classregres').removeClass('d-none')
                    $('#classregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
                }
               }
            })
        })

        //Edit class ajax
        $("#hosteleditform").submit(function(e){
            e.preventDefault();
            removeValidationClasses($(this));
            $('#submiteditclass').val('PLEASE WAIT...');
            var formData = new FormData($('#hosteleditform')[0]);
            $.ajax({
                method: 'POST',
                url: '{{ route('hostel.edit') }}',
                contentType: false,
                processData: false,
                data: formData,
               //dataType: 'json',
               success: function(res){
                $('#submiteditclass').val('EDIT HOSTEL');
                  // console.log(res)
                   if (res.status == 400) {
                    showError('edithostelname', res.messages.edithostelname);
                   } else if(res.status == 200){
                    fecthhostels();
                    $('#classregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    $('#hosteleditform')[0].reset();
                    //$('#regresponse').text(res.messages)
                    $("#hosteleditModal").modal('hide');
                   }   
               }
            });
        })

        //function to fetchclasses
        function fecthhostels(){
            var sid = {{ session()->get('schooldetails.id') }}
            $.ajax({
                method: 'GET',
                url: `/fetchhostels/${sid}`,
                success: function(res){
                    //console.log(res)
                    if (res.hostels.length == 0) {
                        $('tbody').html('<h5 class="text-danger">There are no hostels registered yet</h5>')
                    } else {
                        $('tbody').html('')
                        $.each(res.hostels, function(key,item){
                            $('tbody').append('<tr>\
                            <td><input value="'+item.id+'" type="checkbox" name="" id="hostelselectbox"></td>\
                            <td>'+item.Name+'</td>\
                        </tr>');
                        })

                        $("#hostelstable").DataTable().fnDestroy()

                        $('#hostelstable').DataTable({
                                ordering: false,
                                paging: false,
                                searching: true
                         });
                    }
                }
            });
        }

//function to fetch details of a class for update
    function fetchhostel(id){
        $.ajax({
                method: 'GET',
                url: `/gethostel/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.hostel;
                    $("#edithostelid").val(data.id)
                    $('#edithostelname').val(data.Name)
                }
            })
        }

    //Handle class editing
    $(document).on('click', '#hosteleditbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#hostelselectbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a hostel to edit');
        } else if(ids.length > 1){
            alert('You can only edit one hostel at a time. Select only one hostel');
        } else {
            fetchhostel(ids)
           $('#hosteleditModal').modal('show'); 
        }
     })

    //Book deleting ajax
     $(document).on('click', '#hosteldeletebtn',function(e){
         e.preventDefault();
         var ids = [];
         $('#hostelselectbox:checked').each(function(i){
            ids[i] = $(this).val();
        })
        
        if (ids.length < 1) {
            alert('You must select hostel(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this hostel? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deletehostel/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fecthhostels();
                    $('#classregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#classregres').text('Sorry!Something went wrong while deleting.Please try again later');  
                   }
                    }
                }) 
            }  
        }
     })
    });
</script>
@endsection