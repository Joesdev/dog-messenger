<?php


namespace App\Services;
use Notifiable;
use App\User;
use App\Services\DogDataService;
use App\Services\ExternalApiService;

class NotificationService
{
    public function notifyNextTwoEmails()
    {
        $emails = User::where('rank', 1)->take(2)->get()->pluck('email')->toArray();
        if(empty($emails)){
        }
        foreach($emails as $email){
            $this->sendNotification($email);
            User::where('email', $email)->update(['rank' => 1]);
        }
    }

    public function sendNotification($email)
    {
        $externalApiService = new ExternalApiService();
        $dogDataService = new DogDataService($externalApiService);
        $updatedArray = $dogDataService->getUpdatedBreedArray($email);
        $filteredUpdatedArray = $dogDataService->getRecordsUnderMaxMiles($updatedArray);
        if(empty($filteredUpdatedArray)){
            return false;
        } else {
            $this->addDogsToFoundDogsTable($filteredUpdatedArray, $email);
            //$notification = new NotificationController();
            //$notification->notifyUsersEmailOfPetArrival($email);
        }
    }

}