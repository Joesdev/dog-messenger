@extends('partials.master')

@section('content')
<header class="bg-header">
    <div class="col-xs-12 col-md-7 col-lg-6 text-center">
       <h1 class= "h1">Find Your<br> New <span style="color: #ff7615;">Best Friend</span></h1>
    </div>
</header>
<!-- 3 steps -->
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
        <div class="row">
            <div class="col-xs-12 padding-bottom">
                 <button class="btn-lg center-block btn-yellow" type="button" aria-haspopup="true" aria-expanded="false">Start Now
                </button>
            </div>
        </div>
    </div>   
</section>
<!-- paralax image quote -->
<section>
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-xs-12 paralax">
                <p class="h1 text-center">Your new best friend is waiting to meet <span style="color: #ff7615;">YOU</span></p>
            </div>
        </div>
    </div>
</section>
<!-- testimonials -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 padding-tb">
                <h1 class="h2 text-center">What Do They Think?</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 padding-bottom-sm">
                        <img class="test-pic center-block" src="images/keith.jpg" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 padding-lr">
                        <p class="text-center h5"><strong>Keith M.</strong></p>
                        <p class="text-center"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis velit omnis atque quaerat sed sunt sequi tempora odio fugiat quisquam dolorum nobis sapiente labore amet dignissimos aut, esse molestias facere.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 padding-bottom-sm">
                        <img class="test-pic center-block" src="images/dog1.jpg" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 padding-lr">
                        <p class="text-center h5"><strong>Potato Man</strong></p>
                        <p class="text-center"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis velit omnis atque quaerat sed sunt sequi tempora odio fugiat quisquam dolorum nobis sapiente labore amet dignissimos aut, esse molestias facere.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 padding-bottom-sm">
                        <img class="test-pic center-block" src="images/dog1.jpg" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 padding-lr">
                        <p class="text-center h5"><strong>Potato Man</strong></p>
                        <p class="text-center"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis velit omnis atque quaerat sed sunt sequi tempora odio fugiat quisquam dolorum nobis sapiente labore amet dignissimos aut, esse molestias facere.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection