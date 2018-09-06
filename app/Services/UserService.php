<?php
namespace App\Services;

use App\User;

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

    public function checkUserToken($token, $email)
    {
        $userToken = User::where('email', $email)->first();
        if($token == $userToken){
            return true;
        } else{
            return false;
        }
    }

    public function getUserToken($email)
    {
        $token = User::where('email', $email)->firstOrFail();
        return $token;
    }
}