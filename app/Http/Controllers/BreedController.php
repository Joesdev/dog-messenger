<?php

namespace App\Http\Controllers;

use App\Breed;
use App\Http\Controllers\NotificationController;
use App\Found_Dog;
use App\Services\ExternalPetApiService;
use App\Services\UserService;
use App\Services\ValidationService;

class BreedController extends Controller
{
    protected $userService;
    protected $externalPetApiService;

    public function __construct(){
        $this->userService = new UserService;
        $this->externalPetApiService = new ExternalPetApiService();
    }

    public function showCollectedArrayOfDogsView($email,$token)
    {
        $isTokenValid = $this->userService->checkUserToken($token, $email);
        $found_dogs = Found_Dog::BreedIdAndMiles($email);
        $userSelection = $this->userService->getUserSelection($email);
        if($isTokenValid == true) {
            $results = $this->externalPetApiService->appendFoundDogCollectionDataToApiData($found_dogs);
            return view('results')->with('dogData', $results)->with('userSelection', $userSelection);
        } else{
            return redirect('/');
        }
    }
}
