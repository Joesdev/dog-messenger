@extends('partials.master')

@section('content')
<nav>
	<div class="container-fluid">
		<div class="row">
			<div class="colxs-12">
				<div class="navbar navbar-default navbar-static-top">
					<p class="navbar-text navbar-right padding-nav-txt"><a href="{{url('/')}}" class="navbar-link txt-black">Home</a></p>
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
								@if($dog['media'] === '#')
									<div class="img img-responsive center-block" style="background-image:url({{url('/images/default_pic.jpg')}});"><h2 class="badge-miles"> <i class="fa fa-map-marker txt-orange fa-lg"></i> {{$dog['distance']}} miles</h2></div>
								@else
									<div class="img img-responsive center-block" style="background-image:url('{{$dog['media']}}');"><h2 class="badge-miles"> <i class="fa fa-map-marker txt-orange fa-lg"></i> {{$dog['distance']}} miles</h2></div>
								@endif
							</div>
							<!-- CONTACT INFO-->
							<div class="col-xs-12 contact-box">
								<br>
								<p class="txt-black"><strong><u>Contact</u></strong></p>
								<p><i class="fa fa-address-book txt-orange"></i><strong> Address:</strong><br>
									Street: {{$dog['address']}}<br>
									City: {{$dog['city']}}<br>
									State: {{$dog['state']}}<br>
								</p>
    							<p><i class="fa fa-envelope txt-orange"></i><strong> Email: </strong> {{$dog['email']}}</p>
								<p><i class="fa fa-phone txt-orange"></i><strong> Phone Number: </strong> {{$dog['phone']}}</p>
							</div>
						</div>
					</div>
					<!-- DOG INFO -->
					<div class="col-xs-12 col-sm-6 col-md-7 col-lg-8 about-box">
						<h2 class="h3 txt-black">{{$dog['name']}}</h2>
						<p class="txt-black"><strong>{{$dog['sex']}}</strong></p>
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