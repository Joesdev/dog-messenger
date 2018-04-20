@extends('partials.master')

@section('content')
<header class="bg-header">
    <div class="col-xs-12 col-md-7 col-lg-6 text-center">
       <h1 class= "h1">Get Alerts the Day <br>a <span style="color: #ff7615;">Dog You Love</span> <br>is Dropped Off <br>at a Local Shelter. 
        <!-- <br> New <span style="color: #ff7615;">Best Friend</span> -->
    </h1>
    </div>
</header>
<!-- 3 steps -->
<section>
    <div class="container">
        <div class="row padding-tb">
            <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">
                <i class="fa fa-paw fa-3x step-icons"></i>      
                <h2 class="h3 txt-black">Enter A Breed
                <small class="text-muted"><br>Tell us what breed of dog you are looking for</small></h2>
            </div>
            <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">
                <i class="fa fa-map-marker fa-3x step-icons"></i>                            
                <h2 class="h3 txt-black">Enter a Location
                <small class="text-muted"><br>Tell us the area you are looking to adopt a dog</small></h2>               
            </div>
            <div class="col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-0 text-center">   
                <i class="fa fa-bell fa-3x step-icons"></i>           
                <h2 class="h3 txt-black">Get Notified
                <small class="text-muted"><br>Receive an email when your new dog has entered a shelter near you</small></h2> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 padding-bottom">
                 <a href="#search">
                    <button class="btn-lg center-block btn-yellow" type="button" aria-haspopup="true" aria-expanded="false">Start Now </button>
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
                <h1 class="h2 text-center txt-black">What Do They Think?</h1>
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
                        <p class="text-center"> I have been looking for a Rottweiler and a frisbee partner. Now, I have found the best of both. Thanks Dogfinder!</p>
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
                        <p class="text-center">  Thanks to Dogfiner I was the first to find out as soon as a pug came into a shelter near me and I picked her up that day. Thank you! </p>
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
                        <p class="text-center">We wanted to adopt a dog who needed some extra love and care and through Dogfinder we found out new family member. So happy!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search at bottom -->

<section>
    <div class="container-fluid search" id="search">
        <div class="row">
            <div class="col-xs-12">
                <form id="regForm" action="">
                    <h1 class="text-center h1">Find Your New Best Friend</h1>
                  <br>
                    <!-- One "tab" for each step in the form: -->
                    <label class="tab text-center h3 txt-black ui-widget" for="breed">What breed of dog are you looking for? <br><br>
                      <p><input placeholder="poodle..." type="text" id="breed"></p>
                    </label>

                    <label class="tab text-center h3 txt-black" for="zip">Enter the zip code where you are looking<br><br>
                      <p><input placeholder="95409..." type="number" id="zip"></p>
                    </label>

                    <label class="tab text-center h3 txt-black" for="miles">How many miles from this zip code are you looking?<br><br>
                      <p><input placeholder="30..." type="number" id="miles"></p>
                    </label>

                    <label class="tab text-center h3 txt-black" for="email">What is your email address?<br><br>
                      <p><input placeholder="jake@gmail.com..." type="text" id="email"></p>
                    </label>
                    <div style="overflow:auto;">
                      <div style="float:right;">
                        <button type="button" id="prevBtn" class="btn-lg" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" id="nextBtn" class="btn-lg" onclick="nextPrev(1)">Next</button>
                      </div>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>





























@endsection