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

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function showCollectedArrayOfDogsView($email)
    {
        $externalPetApiService = new ExternalPetApiService();
        $masterArrayOfDogs = [];
        $found_dogs = Found_Dog::where('email', $email)->get()->map(function ($dogs) {
            return $dogs->only(['new_breed_id','miles']);
        });
        if($found_dogs->count() > 0){
            foreach($found_dogs as $dog){
                $dogData = $externalPetApiService->getExternalDataForSingleDog($dog['new_breed_id']);
                if(!empty($dogData)){
                    $dogData['distance'] = $dog['miles'];
                    array_push($masterArrayOfDogs,$dogData);
                }
            }
            $userSelection = $this->userService->getUserSelection($email);
            return view('results')->with('dogData' ,$masterArrayOfDogs)->with('userSelection',$userSelection);
        } else{
            return view('/welcome')->with('allBreedNames', $allBreedNames = Breed::all());
        }

    }

    public function getHomeView()
    {
        return view('/welcome');
    }
}
