<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Selection;
use App\User;
class FormController extends Controller
{
    public function saveUserRecordToEmail($email, $miles, $breed){
        $selection =
            Selection::create([
                'breed_id' => $this->getBreedIdForDatabase($breed),
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
