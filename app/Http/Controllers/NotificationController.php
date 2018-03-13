<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Notification;
use App\Notifications\PetArrived;


class NotificationController extends Controller
{
    use Notifiable;

    public function notifyUsersEmailOfPetArrival($email){
        Notification::route('mail', $email)->notify(new PetArrived());
    }
}
