<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dog Finder</title>
    <!--- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>
<body>

<!-- <div class="container-fluid"> -->
    @yield('content')
<!-- </div> -->

@include('partials.footer')


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/app.js"></script>
<script src="js/custom.js"></script>

<!-- breed autofill test -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>