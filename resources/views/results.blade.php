@extends('partials.master')

@section('content')
<nav>
	<div class="container-fluid">
		<div class="row">
			<div class="colxs-12">
				<div class="navbar navbar-default navbar-static-top">
					<p class="navbar-text navbar-right padding-nav-txt"><a href="../" class="navbar-link txt-black">Home</a></p>
				</div>
			</div>
		</div>
	</div>
</nav>
<header>
	<div class="container padding-bottom-md">
		<div class="row">
			<div class="col-xs-12">
				<h1 class="text-center txt-black h2">New puppies in shelters within <span style="color: #ff7615;"> {{$userSelection['miles']}}</span> miles from zip code # <span style="color: #ff7615;">{{$userSelection['zipCode']}}</span></h1>
			</div>
		</div>
	</div>
</header>
<section>
	@foreach ($dogData as $dog)
	<div class="container-fluid bg-blue padding-box">
		<div class="row">
			<!-- PICTURE AND LOCATION INFO -->
			<div class="col-sm-12 bg-white">
				<div class="row">
					<!-- DOG PIC -->
					<div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
						<div class="row">
							<div class="col-xs-12 p-0">
								<div class="img img-responsive center-block" style="background-image:url('{{$dog['media']}}');"></div>
							</div>
							<!-- CONTACT INFO-->
							<div class="col-xs-12 contact-box">
								<br>
								<p class="txt-black"><strong>Contact</strong></p>
								<p><i class="fa fa-address-book txt-orange"></i> Sonoma County Humane Society <br>
								11845 Wicks St <br>
								{{$dog['city']}}, {{$dog['state']}} <br>
								91352
								</p>
    							<p><i class="fa fa-envelope txt-orange"></i> {{$dog['email']}}</p>
								<p><i class="fa fa-phone txt-orange"></i> {{$dog['phone']}}</p>
							</div>
						</div>
					</div>
					<!-- DOG INFO -->
					<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8 about-box">
						<h2 class="h3 txt-black">{{$dog['name']}}</h2>
						<p class="txt-black"><strong>{{$dog['sex']}} - {{$dog['age']}}</strong></p>
						<p class="txt-black txt-scroll"><strong>About:</strong> {{$dog['description']}}
						</p>
					</div>	
				</div>
			</div>
		</div>				
	</div>
	@endforeach
</section>

@endsection