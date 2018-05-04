<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUserZip($email)
    {
        $user = User::where('email',$email)->firstOrFail();
        return [
          'zip' => $user->selection->zip,
        ];
    }

    public function getUserBreed($email)
    {
        $user = User::where('email', $email)->with('selection.breed')->firstOrFail();
        $breedName = $user->selection->breed->breed;
        return [
            'name' => $breedName,
        ];
    }
}
