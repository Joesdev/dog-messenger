<?php


namespace App\Services;
use Notifiable;

class NotificationService
{
    public function notifyNextTwoEmails()
    {
        $emails = User::where('rank', 0)->take(2)->get()->pluck('email')->toArray();
        if(empty($emails)){
        }
        foreach($emails as $email){
            $this->sendNotification($email);
            User::where('email', $email)->update(['rank' => 1]);
        }
    }

    public function sendNotification($email)
    {
        $updatedArray = $this->getUpdatedBreedArray($email);
        $filteredUpdatedArray = $this->getRecordsUnderMaxMiles($updatedArray);
        if(empty($filteredUpdatedArray)){
            return false;
        } else {
            $this->addDogsToFoundDogsTable($filteredUpdatedArray, $email);
            //$notification = new NotificationController();
            //$notification->notifyUsersEmailOfPetArrival($email);
        }
    }

}