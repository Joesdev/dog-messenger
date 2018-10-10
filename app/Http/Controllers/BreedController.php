<?php

namespace App\Http\Controllers;

use App\Breed;
use App\Http\Controllers\NotificationController;
use App\Found_Dog;
use App\Services\ExternalPetApiService;
use App\Services\UserService;
use App\Services\ValidationService;
use Carbon\Carbon;

class BreedController extends Controller
{
    protected $userService;
    protected $externalPetApiService;

    public function __construct(){
        $this->userService = new UserService;
        $this->externalPetApiService = new ExternalPetApiService();
    }

    public function showCollectedArrayOfDogsView($email/*,$token*/)
    {
        /*$isTokenValid = $this->userService->checkUserToken($token, $email);
        if($isTokenValid == true) {*/
            $endOfDay = Carbon::now()->endOfDay();
            $found_dogs = Found_Dog::BreedIdAndMiles($email);
            $userSelection = $this->userService->getUserSelection($email);
            //Check if email exists as a key in cache, if not store data in cache with key being user's email
            $results = cache()->remember("$email", $endOfDay, function() use ($found_dogs){
                return $this->externalPetApiService->appendFoundDogCollectionDataToApiData($found_dogs);
            });
            return view('results')->with('dogData', $results)->with('userSelection', $userSelection);
        /*} else{
            return redirect('/');
        }*/
    }
}
