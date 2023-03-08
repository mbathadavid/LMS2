@extends('layouts.layout')

@section('title','Library')

@section('content')
@if($schoolinfo == null)
    <h3 class="text-center text-success">Hello {{ $adminInfo->name }} Click the Link below to update to register your institution</h3>
    <h5 class="text-center"><a href="/schoolreg" class="link-info">Register School</a></h5>
    
    @else 
<div class="container-fluid">

<div class="main">
<div id="sidenavigation" class="sidenav w3-animate-right">
@include('adminFiles.sidebar')
</div>
<div id="main" class="maincontent">
@include('adminFiles.topnav')
<h6>Library Resource(s)</h6>
<!--Issue book modal start--->
<div id="issueBookModal" class="modal w3-animate-left" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success">Issue Book Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" id="issuebookform">
        <div class="row">
            <div class="col-lg-6 border border-2 border-success bg-warning p-2 mb-3">
               <h5 class="text-center">BOOK NUMBER: <span id="booknumber1" class="text-danger"></span></h5>
               <h5 class="text-center">SUBJECT: <span id="booksubject" class="text-danger"></span></h5>
               <h5 class="text-center">CATEGORY: <span id="bookcategory" class="text-danger"></span></h5>
               <h5 class="text-center">PUBLISHER: <span id="bookpublisher" class="text-danger"></span></h5> 
            </div>

            <div class="col-lg-6">
                <input type="text" name="bookid" id="bookid" hidden>
             <div class="form-group mb-2">
             <label for="">Date Borrowed(TODAY)</label>
             <input type="date" id="dateborrowed" name="dateborrowed" class="form-control">
             <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
             <label for="">Anticipated Return Date</label>
             <input type="date" id="returndate" name="returndate" class="form-control">
             <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
             <label for="">Delayed Return Fine Per Day</label>
             <input placeholder="Fine" id="fine" type="number" name="fine" class="form-control">
             <div class="invalid-feedback"></div>
             </div>
             <div class="form-group mb-2">
             <label for="">Select What to Issue With</label>
             <select name="upiadm" id="upiadm" class="form-control">
                <option value="">Select</option>
                <option value="UPI">UPI Number</option>
                <option value="admissonno">Admission Number</option>
             </select>
             <div class="invalid-feedback"></div>
             </div>
             <div id="issueto" class="form-group mb-2 d-none">
                <label for="">Issue To</label>
                    <table class="table" id="tableUPIadms">
                    <thead>
                    <tr>
                        <th scope="col">Select</th>
                        <th scope="col">UPI or Adm.</th>
                        <th scope="col">Name</th>
                    </tr>
                </thead>
                <tbody id="upiadmntable">
                    
                </tbody>
                </table>
                

             </div>
            </div>
            <div class="form-group d-grid">
                <input id="bookissuebtn" class="btn btn-sm btn-primary rounded-0" type="submit" value="ISSUE BOOK">
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Issue book modal end--->

<!---Books modal--->
<div class="modal w3-animate-zoom" id="booksmodal" tabindex="-1" aria-labelledby="booksaddModalLabel">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="booksaddModalLabel">ADD BOOKS</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" method="POST" id="bookform">
        <div class="row">
        <div class="col-lg-6">
            <input type="number" name="sid" value="{{ session()->get('schooldetails.id') }}" id="sid" hidden>
            <div class="form-group mb-2">
             <label for="">Book Number</label>
             <input class="form-control" type="text" name="booknumber" id="booknumber">
             <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
             <label for="">Category</label>
             <select class="form-control" name="category" id="category">
                <option value="">--Select Category--</option>
                <option value="Course Book">Course Book</option>
                <option value="Revision Book">Revision Book</option>
                <option value="Set Book">Set Book</option>
                <option value="Story Book">Story Book</option>
                <option value="Dictionary">Dictionary</option>
                <option value="Kamusi">Kamusi</option>
             </select>
             <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
            <label for="">Class</label>
            <select class="form-control" name="class" id="class">
            @if( session()->get('schooldetails.level') === "SecondarySchool")
             <option value="">--Select Class--</option>
             <option value="FORM ONE">FORM ONE</option>
             <option value="FORM TWO">FORM TWO</option>
             <option value="FORM THREE">FORM THREE</option>
             <option value="FORM FOUR">FORM FOUR</option>
             <option value="GRADE SEVEN">GRADE 7</option>
             <option value="GRADE EIGHT">GRADE 8</option>
             <option value="GRADE NINE">GRADE 9</option>
             <option value="GRADE TEN">GRADE 10</option>
             <option value="GRADE ELEVEN">GRADE 11</option>
             <option value="GRADE TWELVE">GRADE 12</option>
             @else( session()->get('schooldetails.level') === "PrimarySchool")
             <option value="">--Select Class--</option> 
             <option value="Standard ONE">Standard ONE</option>
             <option value="Standard TWO">Standard TWO</option>
             <option value="Standard THREE">Standard THREE</option>
             <option value="Standard FOUR">Standard FOUR</option>
             <option value="Standard FIVE">Standard FIVE</option>
             <option value="Standard SIX">Standard SIX</option>
             <option value="Standard SEVEN">Standard SEVEN</option>
             <option value="Standard EIGHT">Standard EIGHT</option>
             <option value="PP 1">PP 1</option>
            <option value="PP 2">PP 2</option>
            <option value="Grade ONE">Grade 1</option>
            <option value="Grade TWO">Grade 2</option>
            <option value="Grade THREE">Grade 3</option>
            <option value="Grade FOUR">Grade 4</option>
            <option value="Grade FIVE">Grade 5</option>
            <option value="Grade SIX">Grade 6</option>
             @endif

            </select>
            <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group mb-2">
            <label for="">Subject</label>
            <input class="form-control" type="text" name="subject" id="subject">
            <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
                <label for="">Publisher</label>
             <input class="form-control" type="text" name="publisher" id="publisher">
             <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="form-group d-grid">
         <input id="bookregbtn" class="form-control btn btn-info" type="submit" value="ADD BOOK">
        </div>
        </div>
        </div>
        </form>
        </div>
        </div>
        </div>
<!---Books modal--->

<!--Update Book Modal start-->
<div class="modal w3-animate-top" id="bookseditmodal" tabindex="-1" aria-labelledby="booksaddModalLabel">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="booksaddModalLabel">EDIT BOOK</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" method="POST" id="bookupdateform">
        <div class="row">
        <div class="col-lg-6">
            <input type="number" name="bookid" id="bookid1" hidden>
            <div class="form-group mb-2">
             <label for="">Book Number</label>
             <input class="form-control" type="text" name="booknumber2" id="booknumber2">
             <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
             <label for="">Category</label>
             <select class="form-control" name="bookcategory1">
                <option id="bookcategory1"></option>
                <option value="Course Book">Course Book</option>
                <option value="Revision Book">Revision Book</option>
                <option value="Set Book">Set Book</option>
                <option value="Story Book">Story Book</option>
                <option value="Dictionary">Dictionary</option>
                <option value="Kamusi">Kamusi</option>
             </select>
             <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
            <label for="">Class</label>
            <select class="form-control" name="bookclass1" id="class">
             <option id="bookclass1"></option>
             @if( session()->get('schooldetails.level') === "SecondarySchool")
             <option value="FORM ONE">FORM ONE</option>
             <option value="FORM TWO">FORM TWO</option>
             <option value="FORM THREE">FORM THREE</option>
             <option value="FORM FOUR">FORM FOUR</option>
             <option value="GRADE SEVEN">GRADE 7</option>
             <option value="GRADE EIGHT">GRADE 8</option>
             <option value="GRADE NINE">GRADE 9</option>
             <option value="GRADE TEN">GRADE 10</option>
             <option value="GRADE ELEVEN">GRADE 11</option>
             <option value="GRADE TWELVE">GRADE 12</option>
             @else( session()->get('schooldetails.level') === "PrimarySchool")
             <option value="Standard ONE">Standard ONE</option>
             <option value="Standard TWO">Standard TWO</option>
             <option value="Standard THREE">Standard THREE</option>
             <option value="Standard FOUR">Standard FOUR</option>
             <option value="Standard FIVE">Standard FIVE</option>
             <option value="Standard SIX">Standard SIX</option>
             <option value="Standard SEVEN">Standard SEVEN</option>
             <option value="Standard EIGHT">Standard EIGHT</option>
             <option value="PP 1">PP 1</option>
            <option value="PP 2">PP 2</option>
            <option value="Grade ONE">Grade 1</option>
            <option value="Grade TWO">Grade 2</option>
            <option value="Grade THREE">Grade 3</option>
            <option value="Grade FOUR">Grade 4</option>
            <option value="Grade FIVE">Grade 5</option>
            <option value="Grade SIX">Grade 6</option>
             @endif

            </select>
            <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group mb-2">
            <label for="">Subject</label>
            <input class="form-control" type="text" name="booksubject1" id="booksubject1">
            <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-2">
                <label for="">Publisher</label>
             <input class="form-control" type="text" name="bookpublisher1" id="bookpublisher1">
             <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="form-group d-grid">
         <input id="bookupdatebtn" class="form-control btn btn-info" type="submit" value="EDIT BOOK">
        </div>
        </div>
        </div>
        </form>
        </div>
        </div>
        </div>
<!--Update Book Modal start-->

  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 border border-danger border-2 p-3">
        <!-- <h6 class="text-center text-danger">Library Resources Management</h6> -->
        <h5>Number of Books in Store : <b class="text-success"><span id="booksinstore"></span> Books</b></h5>
        <h5>Number of Borrowed Books : <b class="text-danger"><span id="borrowedbooks"></span> Books</b></h5>
        <hr>
        <button data-bs-toggle="modal" data-bs-target="#booksmodal" type="button" class="btn btn-sm btn-danger"><i class="fas fa-plus-circle"></i>&nbsp;ADD A BOOK</button>

        <div id="booksregres" class="text-center d-none"></div>
        <div class="table-responsive">
        <div id="actionbtns" class="mb-2">
        <button id="bookcollectbtn" class="btn btn-sm btn-info float-end">Collect Book</button>
        <button id="issuebooksbtn" class="btn btn-sm btn-success float-end">Issue Book</button>
        <button id="bookseditbtn" type="button" class="btn btn-sm btn-warning float-end"><i class="fas fa-edit"></i>&nbsp;Edit</button> 
        <button id="bookdeletebtn" class="btn btn-sm btn-danger float-end"><i class="fas fa-trash-alt"></i>&nbsp;Delete</button>
         
        </div>
        <table class="table" id="tableforbooks">
            <thead>
            <tr>
                <th scope="col"><input type="checkbox" id="CheckAll"></th>
                <th scope="col">Book No.</th>
                <th scope="col">Category</th>
                <th scope="col">Class</th>
                <th scope="col">Subject</th>
                <th scope="col">Publisher</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody id="bookstable">
            
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
function preview(){
        frame.src=URL.createObjectURL(event.target.files[0]);
        }
</script>
<script>
    $(document).ready(function(){
        fetchbooks();

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

     //function to fetch books
     function fetchbooks(){
            var sid = "{{ session()->get('schooldetails.id') }}";
            $.ajax({
                method: 'GET',
                url: `/fetchbooks/${sid}`,
                //dataType: 'jsons',
                success: function(res) {
                $("#booksinstore").text(res.booksinstore);
                $("#borrowedbooks").text(res.borrowedbooks);

                $('#bookstable').html('');
                  $.each(res.books,function(key,item){
                    if (item.Status == 'In Store') {
                    $('#bookstable').append('<tr>\
                    <td><input id="bookcheckbox" type="checkbox" value="'+item.id+'" name="id[]"></td>\
                    <td>'+item.BookNumber+'</td>\
                    <td>'+item.Category+'</td>\
                    <td>'+item.Class+'</td>\
                    <td>'+item.Subject+'</button></td>\
                    <td>'+item.Publisher+'</td>\
                    <td>'+item.Status+'</td>\
                    </tr>') 
                    } else {
                    $('#bookstable').append('<tr>\
                    <td><input id="bookcheckbox" type="checkbox" value="'+item.id+'" name="id[]"></td>\
                    <td>'+item.BookNumber+'</td>\
                    <td>'+item.Category+'</td>\
                    <td>'+item.Class+'</td>\
                    <td>'+item.Subject+'</button></td>\
                    <td>'+item.Publisher+'</td>\
                    <td>'+item.Status+' by <b class="text-danger">'+item.borrowed_by+'</b></td>\
                    </tr>')   
                    }  
                  })

                  $("#tableforbooks").DataTable().fnDestroy()

                    $('#tableforbooks').DataTable({
                    ordering: false,
                    paging: true,
                    searching: true
                        });

                }
            })
        }
     //Register Books
     $('#bookform').submit(function(e){
         $('#bookregbtn').val('PLEASE WAIT...');
         removeValidationClasses($('#bookform'))
         e.preventDefault();
         var formdata = new FormData($(this)[0]);
         $.ajax({
             method: 'POST',
             url: '/registerbook',
             contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            success: function(res) {
                if (res.status == 400) {
                $('#bookregbtn').val('ADD BOOK');
                showError('booknumber', res.messages.booknumber);
                showError('category', res.messages.category);
                showError('class', res.messages.class);
                showError('subject', res.messages.subject);
                showError('publisher', res.messages.publisher);
                } else if(res.status == 200){
                removeValidationClasses($('#bookform'))
                $('#bookform')[0].reset();
                $('#bookregbtn').val('ADD BOOK');
                $('#booksregres').removeClass('d-none');
                $('#booksregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $('#booksmodal').modal('hide');
                fetchbooks();   
                } else if(res.status == 401){
                    showError('booknumber', res.messages);
                }
            }
         })
     })
     //Update book ajax request
     $('#bookupdateform').submit(function(e){
         $('#bookupdatebtn').val('PLEASE WAIT...');
         e.preventDefault();
         var formdata = new FormData($(this)[0]);
         $.ajax({
             method: 'POST',
             url: '/updatebook',
             contentType: false,
            processData: false,
            dataType: 'json',
            data: formdata,
            success: function(res) {
                if (res.status == 400) {
                $('#bookupdatebtn').val('EDIT BOOK');
                showError('booknumber2', res.messages.booknumber2);
                showError('bookcategory1', res.messages.bookcategory1);
                showError('bookclass1', res.messages.bookclass1);
                showError('booksubject1', res.messages.booksubject1);
                showError('bookpublisher1', res.messages.bookpublisher1);
                } else if(res.status == 200){
                $('#bookupdateform')[0].reset();
                $('#bookupdatebtn').val('EDIT BOOK');
                $('#booksregres').removeClass('d-none');
                $('#booksregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $('#bookseditmodal').modal('hide');
                fetchbooks();   
                }
            }
         })
     })

     //handle selection of books
     $(document).on('change', '#bookcheckbox',function(e){
        e.preventDefault();
        $('#actionbtns').removeClass('d-none');
     })
     //CheckAll
     $('#CheckAll').click(function(){
         if ($(this).is(':checked')) {
             $('#bookcheckbox').prop('checked',true);
         } else {
            $('#bookcheckbox').prop('checked',false);
         }
         $('#actionbtns').removeClass('d-none');
     })

    //function to fetch details on one book
    function fetchBook(id){
        $.ajax({
                method: 'GET',
                url: `/getBook/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.bookdetails;
                    $('#bookid').val(data.id)
                    $('#booknumber1').text(data.BookNumber);
                    $('#bookcategory').text(data.Category);
                    $('#bookpublisher').text(data.Publisher);
                    $('#booksubject').text(data.Subject);
                }
            })
    }
    //function to fetch details of a book for update
    function fetchBook2(id){
        $.ajax({
                method: 'GET',
                url: `/getBook/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.bookdetails;
                    $('#bookid1').val(data.id)
                    $('#booknumber2').val(data.BookNumber);
                    $('#bookcategory1').text(data.Category);
                    $('#bookcategory1').val(data.Category);
                    $('#bookclass1').text(data.Class);
                    $('#bookclass1').val(data.Class);
                    $('#bookpublisher1').val(data.Publisher);
                    $('#booksubject1').val(data.Subject);
                }
            })
    }

    //check book status
    function fetchBookStatus(id){
        $.ajax({
                method: 'GET',
                url: `/getBook/${id}`,
                //dataType: 'jsons',
                success: function(res) {
                    var data = res.bookdetails;
                    var status = res.bookdetails.Status;
                    if (status === "Borrowed") {
                        alert('This Book has already been issued to someone')
                    } else if(status === "In Store"){
                        $('#issueBookModal').modal('show');
                    } 
                }
            })
    }
    
    //Select the adm or Upi
     $("#upiadm").change(function(e){
        var value = $(this).val();
        //$('#upiadmntable').html('');
        if (value !== "") {
            $("#issueto").removeClass('d-none')
            $("#bookissuebtn").removeClass('d-none')

            var sid = "{{ session()->get('schooldetails.id') }}";

            var filter = {
                'filtervalue' : 'ALL'
            }
                $.ajax({
                    method: 'GET',
                    url: `/filterStudents/${filter.filtervalue}/${sid}`,
                    success: function(res){
                    //console.log(res);
                    $('#upiadmntable').html('');
                    if (value == "UPI") {
                        $.each(res.students, function(key,item){
                            $('#upiadmntable').append('<tr>\
                            <td><input id="studentcheckbox" type="checkbox" value="'+item.UPI+'" name="admnos[]"></td>\
                            <td>'+item.UPI+'</td>\
                            <td>'+item.Fname+' '+item.Lname+'</td>\
                            </tr>');
                        })  

                        $("#tableUPIadms").DataTable().fnDestroy()

                        $('#tableUPIadms').DataTable({
                        ordering: false,
                        paging: true,
                        searching: true
                            });
                    } else if (value == "admissonno"){
                        $.each(res.students, function(key,item){
                            $('#upiadmntable').append('<tr>\
                            <td><input id="studentcheckbox" type="checkbox" value="'+item.AdmissionNo+'" name="admnos[]"></td>\
                            <td>'+item.AdmissionNo+'</td>\
                            <td>'+item.Fname+' '+item.Lname+'</td>\
                            </tr>');
                        }) 
                        
                        $("#tableUPIadms").DataTable().fnDestroy()

                        $('#tableUPIadms').DataTable({
                        ordering: false,
                        paging: true,
                        searching: true
                            });
                    }
                    }
                    })
        } else {
            $("#issueto").addClass('d-none')
            $("#bookissuebtn").addClass('d-none')
        }
     }) 

    //Function to filter to fetch students
        // function fetchStudents(){
        //     var sid = "{{ session()->get('schooldetails.id') }}";

        //     var filter = {
        //         'filtervalue' : 'ALL'
        //     }
        //         $.ajax({
        //             method: 'GET',
        //             url: `/filterStudents/${filter.filtervalue}/${sid}`,
        //             success: function(res){
        //                 $('#admnos').html('');
        //                 $.each(res.students, function(key,item){
        //                     $('#admnos').append('<option value="'+item.AdmissionNo+'">');
        //                 })
        //             }
        //             })
        //         }

     //show issue book modal
     $(document).on('click', '#issuebooksbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#bookcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length > 1) {
            alert('You can only issue one book at a time');
        } else {
       fetchBookStatus(ids);
            fetchBook(ids)
            //fetchStudents()
           //$('#issueBookModal').modal('show'); 
        }
     })
     //Handle book editing
     $(document).on('click', '#bookseditbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#bookcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        if (ids.length < 1) {
            alert('Please select a book to edit');
        } else if(ids.length > 1){
            alert('You can only edit one book at a time. Select only one Book');
        } else {
            fetchBook2(ids)
           $('#bookseditmodal').modal('show'); 
        }
     })

     //Book collect ajax request
     $(document).on('click', '#bookcollectbtn',function(e){
         e.preventDefault();
         var ids = []
         $('#bookcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        var confirm = window.confirm(`Are you sure the book has been returned? Make sure it is handed over to you for collection`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/collectbook/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchbooks();
                    $('#booksregres').removeClass('d-none');
                    $('#booksregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#booksregres').removeClass('d-none');
                    $('#booksregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>"Sorry! Unknown error, please try again later."</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
        } else {
            
        } 
     })
     //Book deleting ajax
     $(document).on('click', '#bookdeletebtn',function(e){
         e.preventDefault();
         var ids = []
         $('#bookcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })
        
        if (ids.length < 1) {
            alert('You must select book(s) to delete')
        } else {
            var confirm = window.confirm(`Are you sure you want to delete this book? You will not be able to revert this action one executed`);
        if (confirm) {
            $.ajax({
                method: 'GET',
                url: `/deletebook/${ids}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res){
                    //console.log(res)
                   if (res.status == 200) {
                    fetchbooks();
                    $('#booksregres').removeClass('d-none');
                    $('#booksregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                   } else {
                    $('#booksregres').removeClass('d-none');
                    $('#booksregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>"Sorry! Something went wrong. Please try agin Later."</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');  
                   }
                    }
                }) 
            }  
        }
     })

     //Book issuing ajax request
        $('#issuebookform').submit(function(e){
            e.preventDefault();
         $('#bookissuebtn').val('PLEASE WAIT...');

         var ids = []
         $('#studentcheckbox:checked').each(function(i){
            ids[i] = $(this).val()
        })

        if (ids.length < 1) {
            alert("Please Select a Student to whom you are going to issue the book");
        } else if (ids.length > 1) {
            alert("Please Select only one student. The book Can Only be Issued to One Student");
        } else {
         var formdata = new FormData($(this)[0]);
         formdata.append('admnos',ids);

         $.ajax({
             method: 'POST',
             url: '/issuebook',
             contentType: false,
            processData: false,
           // dataType: 'json',
            data: formdata,
            success: function(res) {
                if (res.status == 400) {
                $('#bookissuebtn').val('ISSUE BOOK');
                showError('dateborrowed', res.messages.dateborrowed);
                showError('returndate', res.messages.returndate);
                showError('fine', res.messages.fine);
                showError('admnos', res.messages.admnos);
                } else if(res.status == 200){
                $('#bookissuebtn').val('ISSUE BOOK');
                $('#booksregres').removeClass('d-none');
                $('#booksregres').html('<div class="alert alert-success alert-dismissible w3-animate-zoom show" role="alert"><strong>'+res.messages+'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $('#booksmodal').modal('hide');
                $('#issueBookModal').modal('hide');
                $('#issuebookform')[0].reset();
                fetchbooks();   
                }
            }
         })
        }
     })
    
    })
</script>

@endsection