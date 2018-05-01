<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUserZip($email)
    {
        $user = User::where('email',$email)->firstOrFail();
        return $user->selection->zip;
    }
}
