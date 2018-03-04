<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Notification;
use App\Notifications\PetArrived;


class NotificationController extends Controller
{
    use Notifiable;

    public function notifyUsersEmailOfPetArrival(){
        Notification::route('mail', 'joesilvpb4@gmail.com')->notify(new PetArrived());
    }
}
