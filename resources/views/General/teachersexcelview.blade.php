<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontcss/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body style="background-color: #e6e6e6;">
    <div class="container">
        <a href="/teachers" class="text-decoration-none btn btn-primary">
            <i class="fas fa-angle-left"></i><i class="fas fa-angle-left"></i>Back</a>
        <h5 class="text-center text-danger">Upload Teachers From Excel</h5>
        <div class="row">
            <div class="col-md-6 border border-success border-2">
                <h6 class="text-center text-success">Instructions on how to upload from Excel(Please Read before Proceeding)</h6>
                <a href="/downloadteacherstemplate" class="btn btn-sm btn-success">Download Excel Sheet</a>
                <ol type="I">
                    <li class="p-1">Click the <b>Download Excel Sheet</b> button above to download the Excel sheet which is to be filled.It will
                download an excel sheet called <b>teacherstemplate.xlsx</b></li>
                    <li class="p-1">Populate it with the Teachers information accordingly</li>
                    <li class="p-1">Under the <b>Salutation</b> Column in the sheet,Enter the teachers' salutation e.g Mr,Mrs,Miss,Madam etc</li>
                    <li class="p-1">Under the <b>First Name</b> Column, Enter the first name of the teacher</li>
                    <li class="p-1">Under the <b>Second Name</b> Colunm, Enter the second name of the teacher</li>
                    <li class="p-1">Under the <b>Last Name</b> Column, Enter the third name of the teacher</li>
                    <li class="p-1">Under the <b>Gender</b> Column, Enter the gender of the teacher</li>
                    <li class="p-1">Under the <b>Position</b> Column, Enter the teacher's position if any,eg Principal, Deputy Principal, Senior Teacher,
                        Teacher, Games Captain etc</li>
                    <li class="p-1">Under the <b>Email</b> Column, Enter the teacher's Email Address if any</li>
                    <li class="p-1">Under the <b>Phone</b> Column, Enter the teachers's Phone number.</li>
                    <li class="p-1 text-danger text-bold">The <b>Phone</b> and <b>Email</b> for each teacher must be unique because
                 <b>we can not have two people sharing the same Phone Number or Email.</b>Make sure these columns do not have duplicate 
                values otherwise the system will throw errors.</li>
                <li class="p-1">Once you are done with populating the data coome back and Click the <b>Choose File</b> button to select it
            from our computer and upload.</li>
                </ol>
            </div>
            <div class="col-md-6 border border-danger border-2">
            <h6>Already have the Excel Sheet Filled? Click the <b>Choose File</b> button below to select the <b>teacherstemplate.xlsx</b> from your Computer and upload</h6>
            <form id="teacheruploadform" enctype="multipart/form-data" method="POST" action="#">
                <h6 id="teachersimport" class="text-center text-success bg-info p-2 d-none"></h6>
                @csrf
                <div class="form-group mb-2">
                    <input class="form-control" type="file" name="file" id="file">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group d-grid">
                <button type="submit" class="btn btn-success">UPLOAD EXCEL SHEET</button>
                </div>
            </form>
            </div>
        </div>
    </div>
  
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script src="{{ asset('js/fontjs/all.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#teacheruploadform').submit(function(e){
            e.preventDefault();
            var data = new FormData($(this)[0]);
            $.ajax({
                method: 'POST',
                url: '{{ route('teacher.import') }}',
                contentType: false,
                processData: false,
                dataType: 'json',
                data: data,
                success: function(res){
                    if (res.status == 400) {
                        showError('file', res.messages.file);
                    } else if(res.status == 200){
                        $('#teachersimport').removeClass('d-none');
                        $('#teachersimport').text(res.messages);
                    }
                }
            })
        })
    })
</script>
</body>
</html>