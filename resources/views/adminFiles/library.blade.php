@extends('layouts.layout')

@section('title','Library')

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
<h4>Librarian(s)</h4>
<!--Librarians modal start--->
<div class="modal fade" id="librarianmodal" tabindex="-1" aria-labelledby="teacheraddModalLabel">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success text-center" id="teacheraddModalLabel">Register Librarian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="#" method="POST" enctype="multipart/form-data" id="librarianform">
            <div class="row">
                <div class="col-lg-6">
                 <div class="form-group mb-2">
                  <label for="">First Name</label>
                  <input type="text" name="firstname" id="firstname" class="form-control">
                  <div class="invalid-feedback"></div>
                 </div>
                 <div class="form-group mb-2">
                  <label for="">Last Name</label>
                  <input type="text" name="lastname" id="lastname" class="form-control">
                  <div class="invalid-feedback"></div>
                 </div>
                 <div class="form-group mb-2">
                  <label for="">Activate Account?</label><br>
                  <input type="checkbox" name="active" value="Yes" id="active">&nbsp;Activate
                  <div class="invalid-feedback"></div>
                 </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group mb-2">
                  <label for="">Email</label>
                  <input type="email" name="email" id="email" class="form-control">
                  <div class="invalid-feedback"></div>
                 </div>
                 <div class="form-group mb-2">
                  <label for="">Phone Number</label>
                  <input type="tel" name="phone" id="phone" class="form-control">
                  <div class="invalid-feedback"></div>
                 </div>
                 <div class="form-group mb-2">
                  <label for="">Profile</label>
                  <input onchange="preview()" type="file" name="file" id="file" class="form-control">
                  <div class="invalid-feedback"></div>
                 </div>
                </div>

                <div class="text-center mb-3">
                    <img width="150" id="frame" height="150" class="img-fluid" src="{{ asset('images/avatar.png') }}" alt="">
                    </div>
                <div class="form-group mb-1 d-grid">
                    <input id="reglibbtn" class="btn btn-success" type="submit" value="REGISTER LIBRARIAN">
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<!--Librarians modal end--->

  <div class="row d-flex justify-content-center align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 border border-success border-2 p-2 mr-3">
        <h6 class="text-center text-danger">Librarians Management</h6>
    <h6 id="libregres" class="text-center text-success bg-info p-2 d-none"></h6>
    <button data-bs-toggle="modal" data-bs-target="#librarianmodal" type="button" class="btn btn-sm btn-danger"><i class="fas fa-plus-circle"></i>&nbsp;REGISTER LIBRARIAN</button>
     <div class="table-responsive">
     <table class="table" id="table">
            <thead>
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Profile</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>  
            </tr>
        </thead>
        <tbody id="libarianstable">
           @foreach($librarians as $librarian)
           <tr>
               <td><input type="checkbox" value="{{ $librarian->id }}"></td>
               <td><img height="50" width="50" src="images/{{$librarian->profile}}" class="img-fluid" alt=""></td>
               <td>{{ $librarian->firstname }} {{ $librarian->lastname }}</td>
               <td><button class="btn btn-sm btn-info">{{ $librarian->Active }}</button></td>
               <td>{{ $librarian->Email }}</td>
               <td>{{ $librarian->Phone }}</td>
           </tr>
           @endforeach
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
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        //Function to fetch librarians
        function fetchlibrarian(){
            $.ajax({
                method: 'GET',
                url: '/fetchlibarians',
                //dataType: 'jsons',
                success: function(res) {
                $('#libarianstable').html('');
                  $.each(res.librarians,function(key,item){
                    $('#libarianstable').append('<tr>\
                    <td><input type="checkbox" value="'+item.id+'"></td>\
                    <td><img height="50" width="50" src="images/'+item.profile+'" class="img-fluid" alt=""></td>\
                    <td>'+item.firstname+' '+item.lastname+'</td>\
                    <td><button class="btn btn-success btn-sm">'+item.Active+'</button></td>\
                    <td>'+item.Email+'</td>\
                    <td>'+item.Phone+'</td>\
                    </tr>')  
                  })
                }
            })
        }

     $('#librarianform').submit(function(e){
         e.preventDefault();
         $('#reglibbtn').val('PLEASE WAIT...')
         var formdata = new FormData($(this)[0]);
         $.ajax({
                method: 'POST',
                url: '{{ route('librian.register') }}',
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formdata,
                success: function(res){
                    if (res.status == 400) {
                        $('#reglibbtn').val('REGISTER LIBRARIAN')
                        showError('file', res.messages.file);
                        showError('firstname', res.messages.firstname);
                        showError('lastname', res.messages.lastname);
                        showError('email', res.messages.email);
                        showError('phone', res.messages.phone);
                    } else if(res.status == 200){
                        $('#reglibbtn').val('REGISTER LIBRARIAN')
                        $('#libregres').removeClass('d-none');
                        $('#libregres').text(res.messages)
                        $('#librarianform')[0].reset();
                        $("#librarianmodal").modal('hide');
                        fetchlibrarian() 
                    }
                }
            })
     })

     //function to fetch books
     function fetchbooks(){
            $.ajax({
                method: 'GET',
                url: '/fetchbooks',
                //dataType: 'jsons',
                success: function(res) {
                $('#bookstable').html('');
                  $.each(res.books,function(key,item){
                    $('#bookstable').append('<tr>\
                    <td><input type="checkbox" value="'+item.id+'"></td>\
                    <td>'+item.BookNumber+'</td>\
                    <td>'+item.Category+'</td>\
                    <td>'+item.Subject+'</button></td>\
                    <td>'+item.Publisher+'</td>\
                    <td>'+item.Status+'</td>\
                    </tr>')  
                  })
                }
            })
        }
     //Register Books
     $('#bookform').submit(function(e){
         $('#bookregbtn').val('PLEASE WAIT...');
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
                $('#bookregbtn').val('ADD BOOK');
                $('#booksregres').removeClass('d-none');
                $('#booksregres').text(res.messages);
                $('#booksmodal').modal('hide');
                fetchbooks();   
                }
            }
         })
     })

    })
</script>

@endsection