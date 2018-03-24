<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Selection;
use App\User;
use App\Http\Controllers\BreedStatusController;

class FormController extends Controller
{
    public function saveUserRecordToEmail($email='etha2@gmail.com', $miles=44, $breed='Bearded Collie', $zip = "91306"){
        $breedController = new BreedStatusController();
        $breedArray = $breedController->getExternalDataForBreed($zip,$breed);
        $selection =
            Selection::create([
                'breed_id' => $breedController->getBreedIdForDatabase($breed),
                'zip' => $zip,
                'highest_breed_id' => $breedController->getLargestBreedId($breedArray),
                'max_miles' => $miles,
                'match'     => false
            ])
        ;

        User::create([
            'rank' => 0,
            'name' => 'user',
            'email' => $email,
            'selection_id' => $selection->id,

        ]);
    }

}
