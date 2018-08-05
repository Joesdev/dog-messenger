<?php
namespace App\Services;

use App\User;
use App\Breed;
use App\Selection;
use App\Found_Dog;

class UserService
{
    public function getUserSelection($email)
    {
        $user = User::where('email', $email)->with('selection')->firstOrFail();
        $selection = [
            'zipCode' => $user->selection->zip,
            'miles' => $user->selection->max_miles
        ];
        return $selection;
    }


}