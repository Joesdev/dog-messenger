<?php

namespace App\Http\Controllers;

use App\Found_Dog;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\User;
use App\Selection;

class UserController extends Controller
{
    public function getUserZip($email)
    {
        $user = User::where('email',$email)->firstOrFail();
        return [
          'zip' => $user->selection->zip,
        ];
    }

    public function getUserMiles($email)
    {
        $user = User::whereEmail($email)->firstOrFail();
        return [
            'miles' => $user->selection->max_miles,
        ];
    }

    public function destroyUser($email)
    {
            $userSelectionId = User::whereEmail($email)->pluck('selection_id');
            User::whereEmail($email)->delete();
            Selection::where('id', $userSelectionId)->delete();
            Found_Dog::whereEmail($email)->delete();
    }

    public function unsubUser($email, $token)
    {
        $userService = new UserService();
        if($userService->checkUserToken($token, $email)){
            $user = User::whereEmail($email)->first();
            $unsubscribedNumber = 2;
            $user->rank = $unsubscribedNumber;
            $user->save();
        } else {
            return redirect('/');
        }
    }
}
