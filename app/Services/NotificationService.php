<?php


namespace App\Services;
use App\Notifications\PetArrived;
use Notifiable;
use App\User;
use App\Services\DogDataService;
use App\Services\ExternalPetApiService;

class NotificationService
{
    public function notifyNextTwoEmails()
    {
        $emails = User::where('rank', 1)->take(1)->get()->pluck('email')->toArray();
        if (empty($emails)) {
        }
        foreach ($emails as $email) {
            $this->sendNotification($email);
            User::where('email', $email)->update(['rank' => 0]);
        }
    }

    public function sendNotification($email)
    {
        $user = User::where('email', $email)->first();
        $selection = $user->selection()->first();
        $externalPetApiService = new ExternalPetApiService();
        $externalZipApiService = new ExternalZipApiService();
        $dogDataService = new DogDataService($externalPetApiService, $externalZipApiService);
        $updatedArray = $dogDataService->getUpdatedBreedArray($email);
        $filteredUpdatedArray = $dogDataService->getRecordsUnderMaxMiles($updatedArray,$selection->miles,$selection->zip);
        if (empty($filteredUpdatedArray)) {
            return false;
        } else {
            $dogDataService->addDogsToFoundDogsTable($filteredUpdatedArray, $email);
            $user->notify(new PetArrived($user->name));
        }
    }
}

