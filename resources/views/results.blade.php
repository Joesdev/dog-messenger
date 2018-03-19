@extends('partials.master')

@section('content')
<nav>
	<div class="container-fluid">
		<div class="row">
			<div class="colxs-12">
				<div class="navbar navbar-default navbar-static-top">
					<p class="navbar-text navbar-right"><a href="./" class="navbar-link txt-black">Home</a></p>
				</div>
			</div>
		</div>
	</div>
</nav>

<header>
	<div class="container padding-bottom-md">
		<div class="row">
			<div class="col-xs-12">
				<h1 class="text-center txt-black h2"><span style="color: #ff7615;">New</span> <u>poodles</u> in shelters within <u>20</u> miles from zip code # <u>22112</u></h1>
			</div>
		</div>
	</div>
</header>

<section>
	<div class="container-fluid bg-blue padding-box">
		<div class="row">
			<!-- PICTURE AND LOCATION INFO -->
			<div class="col-sm-12 bg-white">
				<div class="row">
					<!-- DOG PIC -->
					<div class="col-xs-12 col-sm-5">
						<div class="row">
							<div class="col-xs-12 p-0">
								<img src="images/puppy.jpg" class="dog-pic-box img-responsive">
							</div>
							<!-- LOCATION -->
							<div class="col-xs-12 padding-box-content">
								<br>
								<p class="txt-black"><strong>Contact</strong></p>
								<p><i class="fa fa-address-book text-orange"></i> Sonoma County Humane Society <br>
								11845 Wicks St <br>
								Sun Valley, CA <br>
								91352
								</p>
								<p><i class="fa fa-envelope text-orange"></i> email@email.com</p>
								<p><i class="fa fa-phone text-orange"></i> 555-555-5555</p>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-7 padding-box-content">
						<h2 class="h3 txt-black">Pogo</h2>
						<p class="txt-black"><strong>Male - 6yrs</strong></p>
						<p ><strong class="txt-black">Health:</strong> Vaccinations up to date, spayed / neutered</p>
						<p><strong class="txt-black">About:</strong> This dog is a courtesy listing and is not part of BCIN's program. If you are interested in Murphy, please contact Bonnie at bonnieeddy@msn.com or 951-813-1821. BCIN provides this service to help owners who must re-home their dog. Please be advised that BCIN has not evaluated nor tested the temperament of any of the dogs that are courtesy listed on our website. Murphy is a 9 year old purebred border collie that needs to find a good home. He is in good health and no known health concerns except he's a little hard of hearing. He walks on the leash, loves car rides, utd on shots, neutered, housebroken, has basically lived inside for the past few years. Has good manners. He does not like some little kids, and some dogs. I now have my hyperactive 5yr old grandson living with us and it's not a good mix. Murphy is a nice dog, and this is difficult, but it is best for him. 
						</p>
					</div>	
				</div>
			</div>
		</div>				
	</div>
</section>

@endsection