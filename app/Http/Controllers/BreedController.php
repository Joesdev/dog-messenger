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
           $tmpDogData = collect($externalPetApiService->getExternalDataForSingleDog($dog['new_breed_id']));

           /* $masterArrayOfDogs[$index] = [
               'name' => $tmpDogData['name']['$t'],
               'age'  => $tmpDogData['age']['$t'],
               'size'  => $tmpDogData['size']['$t'],
               'sex'  => $tmpDogData['sex']['$t'],
               'isMix' => $tmpDogData['mix']['$t'],
               'phone' => $tmpDogData['contact']['phone']['$t'],
               'email' => $tmpDogData['contact']['email']['$t'],
               'address' => $tmpDogData['contact']['address1']['$t'],
               'city' => $city = $tmpDogData['contact']['city']['$t'],
               'distance' => $found_dogs[$index]['miles'] . ' miles',
           ];

            if(empty($tmpDogData['description']['$t'])){
                $masterArrayOfDogs[$index]['bio']  = 'Not Available';
            } else {
                $masterArrayOfDogs[$index]['bio'] = $tmpDogData['description']['$t'];
            }

            foreach($tmpDogData['media']['photos']['photo'] as $photo){
                if(strpos($photo['$t'], 'width=500')){
                    $masterArrayOfDogs[$index]['media'] = $photo['$t'];
                    break;
                }
            };
            dd($masterArrayOfDogs);

            $index++;*/
        }
        return view('results')->with('dogData' ,$masterArrayOfDogs);
    }

}
