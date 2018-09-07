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
        /*$masterArrayOfDogs = [];
        $isTokenValid = $this->userService->checkUserToken($token, $email);
        if($isTokenValid == true) {
            $found_dogs = Found_Dog::where('email', $email)->get()->map(function ($dogs) {
                return $dogs->only(['new_breed_id', 'miles']);
            });
            if ($found_dogs->count() > 0) {
                foreach ($found_dogs as $dog) {
                    $dogData = $externalPetApiService->getExternalDataForSingleDog($dog['new_breed_id']);
                    if (!empty($dogData)) {
                        //Theres two peices of data here, the collection of dog id's and the actual collection of
                        //api information, this block is appending the miles from dog id's to the actual api collection
                        $dogData['distance'] = $dog['miles'];
                        array_push($masterArrayOfDogs, $dogData);
                    }
                }
                $userSelection = $this->userService->getUserSelection($email);
                return view('results')->with('dogData', $masterArrayOfDogs)->with('userSelection', $userSelection);
            } else {
                return view('/welcome');
            }
        } else {
            return redirect('/');
        }*/
        $isTokenValid = $this->userService->checkUserToken($token, $email);
        if($isTokenValid == true) {
            $this->externalPetApiService->routeToHomeOrResultsPage($email);
        } else{
            return redirect('/');
        }
    }

    public function getHomeView()
    {
        return view('/welcome');
    }
}
