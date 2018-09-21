<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics Tracking code -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125573782-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-125573782-1');
    </script>
    <!-- end google analytics -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content='{{ csrf_field() }}'>
    <title>Adopt A Shelter Puppy Near You</title>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="description" content="Be the first to find out when a new puppy is brought into an animal shelter near you through findashelterpuppy.com in three easy steps for free!">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>
</head>
<body>
@yield('content')

@include('partials.footer')

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/app.js"></script>
<script src="js/custom.js"></script>
</body>
</html>