<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Selection;
use App\User;
use App\Http\Controllers\BreedStatusController;

class FormController extends Controller
{
    public function saveUserRecordToEmail($email = 'batman@gmail.com', $miles = 50, $breed = 'Bloodhound'){
        $breedController = new BreedStatusController();
        $selection =
            Selection::create([
                'breed_id' => $breedController->getBreedIdForDatabase($breed),
                'highest_breed_id' => 0,
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
