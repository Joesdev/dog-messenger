@extends('partials.master')

@section('content')
<header class="bg-header">
    <div class="col-xs-12 col-md-7 col-lg-6 text-center">
       <h1>Find Your<br> New <span style="color: #ff7615;">Best Friend</span></h1>
    </div>
</header>
<section>
        <div class="container">
            <div class="row padding-tb">
                <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">
                    <i class="fa fa-paw fa-3x step-icons"></i>      
                    <h2 class="h3">Enter A Breed
                    <small class="text-muted"><br>Tell us what breed of dog you are looking for</small></h2>
                </div>
                <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">
                        <i class="fa fa-map-marker fa-3x step-icons"></i>                            
                        <h2 class="h3">Enter a Location
                        <small class="text-muted"><br>Tell us the area you are looking to adopt a dog</small></h2>               
                </div>
                <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">   
                        <i class="fa fa-bell fa-3x step-icons"></i>           
                        <h2 class="h3">Get Notified
                        <small class="text-muted"><br>Receive a text and email alert when your new dog has entered a shelter</small></h2> 
                </div>
            </div>
        </div>
    </section>  
@endsection