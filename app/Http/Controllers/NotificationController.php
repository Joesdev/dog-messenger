<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;


class NotificationController extends Controller
{
    use Notifiable;

    public function notifyUsersEmailOfPetArrival($email, $pet){
        // This functions follows a function which determines a pet has arrived
        $invoice = 'am i a message of some kind?';
        Notification::route('mail', 'joesilvpb4@gmail.com')->notify(new InvoicePaid($invoice));
    }
}
