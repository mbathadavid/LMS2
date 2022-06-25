<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontcss/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Excel Trial</title>
</head>
<body>
    <div class="container">
        <div class="table-responsive">
    <table class="table">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Admission No.</th>
                <th scope="col">FisrtName</th>
                <th scope="col">Second Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Status</th>
                <th scope="col">Gender</th>
                <th scope="col">Class</th>
                <th scope="col">Disabled?</th>
                <th scope="col">Disability</th>
                <th scope="col">Description</th>
                <th scope="col">DoB</th>
                <th scope="col">County</th>
                <th scope="col">Sub-County</th>
            </tr>
        </thead>
        <tbody>
           @foreach($students as $student)
           <tr>
               <td>{{ $student->profile }}</td>
               <td>{{ $student->AdmissionNo }}</td>
               <td>{{ $student->Fname }}</td>
               <td>{{ $student->Sname }}</td>
               <td>{{ $student->Lname }}</td>
               <td>{{ $student->Active }}</td>
               <td>{{ $student->gender }}</td>
               <td>{{ $student->current_class }}</td>
               <td>{{ $student->disabled }}</td>
               <td>{{ $student->disability }}</td>
               <td>{{ $student->d_description }}</td>
               <td>{{ $student->dob }}</td>
               <td>{{ $student->county }}</td>
               <td>{{ $student->subcounty }}</td>
           </tr>
           @endforeach
        </tbody>
        </table>
</div>
    </div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="{{ asset('js/fontjs/all.min.js') }}"></script>
    <script>
        $('.navtoggler').click(function(e){
            e.preventDefault();
            $('#sidenavigation').toggleClass('sidenav newsidenav');
            $('#main').toggleClass('maincontent newmaincontent');
        })

        $('#closesidenav').click(function(e){
            e.preventDefault();
            $('#sidenavigation').removeClass('newsidenav')
            $('#sidenavigation').addClass('sidenav')
        })
    </script>
</body>
</html>