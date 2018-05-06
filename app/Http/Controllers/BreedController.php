<?php

namespace App\Http\Controllers;

use App\Http\Controllers\NotificationController;
use App\Found_Dog;
use App\Services\ExternalPetApiService;
use App\Services\ValidationService;

class BreedController extends Controller
{

    public function showCollectedArrayOfDogsView($email)
    {
        $externalPetApiService = new ExternalPetApiService();
        $masterArrayOfDogs = [];
        $index = 0;
        $found_dogs = Found_Dog::where('email', $email)->get();
        $found_dogs = $found_dogs->map(function ($dogs) {
            return $dogs->only(['new_breed_id','miles']);
        });

        foreach($found_dogs as $dog){
            $dogData = $externalPetApiService->getExternalDataForSingleDog($dog['new_breed_id']);
            array_push($masterArrayOfDogs,$dogData);
        }
        // dd($masterArrayOfDogs);
        return view('results')->with('dogData' ,$masterArrayOfDogs);
    }

    public function getUsersBreed(){

    }

}
