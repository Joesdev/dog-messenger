<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\DistanceController;
use App\Http\Controllers\NotificationController;
use App\Found_Dog;
use App\Services\ExternalApiService;

class BreedController extends Controller
{

    public function showCollectedArrayOfDogsView($email)
    {
        $externalApiService = new ExternalApiService();
        $masterArrayOfDogs = [];
        $media = [];
        $index = 0;
        $found_dogs = Found_Dog::where('email', $email)->get();
        $found_dogs = $found_dogs->map(function ($dogs) {
            return collect($dogs->toArray())->only(['new_breed_id','miles'])->all();
        });
        foreach($found_dogs as $dog){
           $tmpDogData = $externalApiService->getExternalDataForSingleDog($dog['new_breed_id']);
            foreach($tmpDogData['media']['photos']['photo'] as $photo){
                if(strpos($photo['$t'], 'width=500')){
                    array_push($media, $photo['$t']);
                }
            };

           $masterArrayOfDogs[$index] = [
               'name' => $tmpDogData['name']['$t'],
               'age'  => $tmpDogData['age']['$t'],
               'size'  => $tmpDogData['size']['$t'],
               'sex'  => $tmpDogData['sex']['$t'],
               'bio'  => $tmpDogData['description']['$t'],
               'isMix' => $tmpDogData['mix']['$t'],
               'phone' => $tmpDogData['contact']['phone']['$t'],
               'email' => $tmpDogData['contact']['email']['$t'],
               'address' => $tmpDogData['contact']['address1']['$t'],
               'city' => $city = $tmpDogData['contact']['city']['$t'],
               'distance' => $found_dogs[$index]['miles'] . ' miles',
               'media' => $media
           ];
           $media = [];
           $index++;
        }
        return view('results')->with('dogData' ,$masterArrayOfDogs);
    }

}
