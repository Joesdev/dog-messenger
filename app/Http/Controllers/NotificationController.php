<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Notification;
use App\Notifications\PetArrived;
use App\Found_Dog;


class NotificationController extends Controller
{
    use Notifiable;

    public function notifyUsersEmailOfPetArrival($email){
        Notification::route('mail', $email)->notify(new PetArrived());
    }

    public function getUserNotificationView($userEmail)
    {
        $found_dogs = new Found_Dog();
        $found_dogs->email = $userEmail;
        $found_dogs->new_breed_id = '8000';
        $found_dogs->miles = 50;
        $found_dogs->save();
        //connect to found_dogs table, return array of ID's and Distances for this email
        //if user email has at least one dog to be displayed){
            //for start
            //query the 'pet.find' api call for each id
            //clean the data
            //add to dogData array
            //for end

    }
}
