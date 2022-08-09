<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
    <!--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css"/>
    -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.lwMultiSelect.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontcss/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/chosen.min.css') }}" rel="stylesheet">
    <!--
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css"/>
    -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <title>@yield('title')</title>
</head>
<body>
    <main>
    @yield('content')
    </main>
    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
-->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.lwMultiSelect.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.table2excel.js') }}"></script>
<script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script src="{{ asset('js/time.js') }}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<!---
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
--->
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="{{ asset('js/fontjs/all.min.js') }}"></script>
    <script>
        $('.navtoggler').click(function(e){
            e.preventDefault();
            $('#sidenavigation').toggleClass('sidenav newsidenav');
            $('#topnavdiv').toggleClass('topnavdiv newtopnavdiv');
            $('#main').toggleClass('maincontent newmaincontent');
        })

        $('#closesidenav').click(function(e){
            e.preventDefault();
            $('#sidenavigation').removeClass('newsidenav')
            $('#sidenavigation').addClass('sidenav')
        })
        $('.librarybtn').click(function(e){
            e.preventDefault();
            $('#libdropdown').toggleClass('d-none');
            $('#libicon').toggleClass('d-none');
            $('#libiconup').toggleClass('d-none');
        })
        $('.academicbtn').click(function(e){
            e.preventDefault();
            $('#academicdropdown').toggleClass('d-none');
            $('#acadicon').toggleClass('d-none');
            $('#acadiconup').toggleClass('d-none');
        })
        $('.financesbtn').click(function(e){
            e.preventDefault();
            $('#findropdown').toggleClass('d-none');
            $('#finicon').toggleClass('d-none');
            $('#finiconup').toggleClass('d-none');
        })
        $('.peoplebtn').click(function(e){
            e.preventDefault();
            $('#peopledropdown').toggleClass('d-none');
            $('#peopleicon').toggleClass('d-none');
            $('#peopleiconup').toggleClass('d-none');
        })
        $('.communicatebtn').click(function(e){
            e.preventDefault();
            $('#commsdropdown').toggleClass('d-none');
            $('#commicon').toggleClass('d-none');
            $('#commiconup').toggleClass('d-none');
        })
    </script>
    <script>
        $(document).ready(function(){
            function showtimer(){
                var datetime = new Date();
                var hour = datetime.getHours();
                if (hour < 12) {
                    document.getElementById('greetuser').innerHTML = 'Good Morning';
                } else if(hour >= 12 && hour < 15){
                    document.getElementById('greetuser').innerHTML = 'Good Afternoon';
                } else if(hour >= 15) {
                    document.getElementById('greetuser').innerHTML = 'Good Evening'; 
                }
                document.getElementById('month').innerHTML = datetime.getMonth();
                document.getElementById('date').innerHTML = datetime.getDate();
                document.getElementById('year').innerHTML = datetime.getFullYear();
                if (datetime.getHours() < 10) {
                    document.getElementById('hour').innerHTML = '0'+`${datetime.getHours()}`;
                } else {
                    document.getElementById('hour').innerHTML = datetime.getHours();
                }
                

                if (datetime.getMinutes() < 10) {
                    document.getElementById('minute').innerHTML = '0'+`${datetime.getMinutes()}`;
                } else {
                    document.getElementById('minute').innerHTML = datetime.getMinutes(); 
                }
                
                if (datetime.getSeconds() < 10) {
                    document.getElementById('second').innerHTML = '0'+`${datetime.getSeconds()}`;
                } else {
                    document.getElementById('second').innerHTML = datetime.getSeconds();  
                }
                
            }

            var timing = setInterval(showtimer,1000);

            
            //setInterval(timing,1000);
        })
    </script>
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/62ac7eac7b967b1179950f47/1g5ostl3n';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
</script>
@yield('script')
</body>
</html>