<?php

namespace App\Http\Controllers;

use App\Breed;
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
        $found_dogs = Found_Dog::where('email', $email)->get()->map(function ($dogs) {
            return $dogs->only(['new_breed_id','miles']);
        });
        if($found_dogs->count() > 0){
            foreach($found_dogs as $dog){
                $dogData = $externalPetApiService->getExternalDataForSingleDog($dog['new_breed_id']);
                array_push($masterArrayOfDogs,$dogData);
            }
            return view('results')->with('dogData' ,$masterArrayOfDogs);
        } else{
            return view('/welcome');
        }

    }

    public function getHomeView()
    {
        $allBreedNames = Breed::all();
        return $allBreedNames;
        //return home view with the array
    }
}
