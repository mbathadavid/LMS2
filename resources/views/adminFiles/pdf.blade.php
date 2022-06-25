<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--
    <link href="public_path('css/style.css')" rel="stylesheet">
    <link href="('css/fontcss/all.min.css')" rel="stylesheet">
    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet">
       -->
       <style>
           body {
               background-color: whitesmoke
           }
           h1 {
               text-align: center
           }
           h3 {
               text-align: center
           }
           img{
               text-align: center
           }
       </style>
    <title>Document</title>
</head>
<body>
    <img src="images/{{ $schoolinfo->logo }}" alt="">
    <h1 class="text-danger text-center">{{ $schoolinfo->name }}</h1>
    <h3 class="text-info text-center">{{ $schoolinfo->motto }}</h3>

 <!--   
<script src="public_path('js/bootstrap.bundle.min.js')"></script>
<script src="public_path('js/jquery.min.js')"></script>
<script src="public_path('js/functions.js')"></script>
<script src="public_path('js/fontjs/all.min.js')"></script>
-->
</body>
</html>