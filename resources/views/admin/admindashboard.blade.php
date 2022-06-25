<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="container">
@include('adminFiles.sidenav')
</div>
<h1 class="text-center text-danger">This is the Admins Home</h1>
<a href="{{ route('admin.logout') }}">Logout</a>


{{ $schoolinfo->name }}
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        
    })
</script>
</body>
</html>