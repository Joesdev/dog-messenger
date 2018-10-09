@extends('partials.master')

@section('content')
<header class="bg-header">

<!-- alert for wrong zip code input -->
<div class="alert alert-warning alert-dismissible collapse" role="alert" id="zip-alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  @foreach ($errors->all() as $error)
  <strong><p>{{$error}} </p></strong>
    @endforeach
  <p>Please make the corrections and resubmit the form <a href="#search">below.</a> Thank you. </p>
</div>
<!-- end alert -->
    <div class="col-xs-12 col-md-7 col-lg-6 text-center">
       <h1 class= "h1">Be the First to Know <br> When <span style="color: #ff7615;">Puppies</span> Arrive <br>at Local Shelters <br>Near You
        </h1>
    </div>
</header>
<!-- 3 steps -->
<section>
    <div class="container">
        <div class="row padding-tb">
            <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">
                <a href="#search"><i class="fa fa-map-marker fa-3x step-icons"></i></a>
                <h2 class="h3 txt-black">Enter a Location
                <small class="text-muted"><br>Tell us the area where you are looking to adopt a puppy</small></h2>               
            </div>
            <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">
                <a href="#search"><i class="fa fa-arrows-alt fa-3x step-icons"></i></a>
                <h2 class="h3 txt-black">Enter A Distance
                <small class="text-muted"><br>Tell us how many miles away you are looking to adopt a puppy </small></h2>
            </div>
            <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">
                <a href="#search"><i class="fa fa-bell fa-3x step-icons"></i></a>
                <h2 class="h3 txt-black">Get Notified
                <small class="text-muted"><br>Receive an email when a puppy has entered a shelter near you</small></h2> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 padding-bottom">
                 <a href="#search">
                    <button class="btn-lg center-block btn-yellow orange-hov" type="button" aria-haspopup="true" aria-expanded="false">Start Now </button>
                </a>
            </div>
        </div>
    </div>   
</section>
<!-- paralax image quote -->
<section>
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-xs-12 paralax">
                <p class="h1 text-center">Your new best friend is waiting to meet <span style="color: $main-orange;">YOU</span></p>
            </div>
        </div>
    </div>
</section>
<!-- testimonials -->
<section>
    <div class="container margin-tb">
        <div class="row">
            <div class="col-sm-12 padding-bottom">
                <h1 class="h2 text-center txt-black">What Do Users Think?</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 padding-bottom-sm">
                        <img class="test-pic center-block" src="images/tiah.jpg" alt="Tiah"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 padding-lr">
                        <p class="text-center h5 txt-black"><strong>Tiah J.</strong></p>
                        <p class="text-center"> I have been looking for a Rottweiler puppy to adopt near me and I found my perfect puppy for free through findashelterpuppy.com. Thanks so much!</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 padding-bottom-sm">
                        <img class="test-pic center-block" src="images/keith.jpg" alt="Keith" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 padding-lr">
                        <p class="text-center h5 txt-black"><strong>Keith M.</strong></p>
                        <p class="text-center">  I was looking for a puppy and a frisbee partner. Findashelterpuppy.com notified me as soon as she was brought into a shelter near me for free! It's been two years and she is my best friend.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 padding-bottom-sm">
                        <img class="test-pic center-block" src="images/lexie.jpg" alt="Lexie" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 padding-lr">
                        <p class="text-center h5 txt-black"><strong>Lexie D.</strong></p>
                        <p class="text-center">We wanted to find a puppy to adopt near us who needed some extra love and care and we found our new family member and couldn't be happier. Thank you! </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- forms at bottom -->

<section>

<!-- BELOW CODE FOR IF ZIPCODE ERROR THEN SHOW ALERT -->
@if($errors->any())
    <script>
        $(function() {
            $('#zip-alert').show();
        });
    </script>
@endif

    <div class="container-fluid search">
        <div class="row">
                <form id="regForm" action="{{url('/create')}}" method="post">
                    {{ csrf_field() }}
                    <h1 class="text-center h1">Find Your New Best Friend</h1>
                    <br><br>
                    <div class="special-field" style="display:none">
                        <label for="akbar">Akbar</label>
                        <input type="text" name="akbar" id="akbar" value="">
                    </div>
                    <div class="row padding-bottom-sm">
                        <div class="col-sm-4">
                            <input placeholder="Zip Code..." type="number" id="zip" name="zip" required>
                        </div>
                        <div class="col-sm-4">
                            <select name="maxMiles" id="maxMiles" required>
                                <option value="" disabled selected>Miles Away...</option>
                                <option value=25>25 Miles</option>
                                <option value=50>50 Miles</option>
                                <option value=100>100 Miles</option>
                                <option value=150>150 Miles</option>
                            </select>  
                        </div> 
                        <div class="col-sm-4">
                            <input placeholder="Email Address..." type="email" name="email" required>
                        </div>
                    </div>
                    <br>
                   <div class="row">
                        <div class="col-xs-12">
                        <input type="submit" value="Submit" class="btn btn-yellow btn-lg center-block txt-white blue-hov">
                        </div>
                    </div>
                </form>
                <div id="search">

                </div>
        </div>
    </div>
</section>
<!-- success modal popup when form submitted -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden=true>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Success <i class="fa fa-check fa-lg"></i></h4>
      </div>
      <div class="modal-body">
        Your information was submitted successfully! We will send you an email as soon as a puppy is brought into a shelter near you. 
      </div>
    </div>
  </div>
</div>

@if(Session::has('isSuccessful'))
    <script>
        $(function() {
            $('#myModal').modal('show');
        });
    </script>
@endif





@endsection