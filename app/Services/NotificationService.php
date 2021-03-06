<?php


namespace App\Services;
use App\Notifications\PuppyArrived;
use Notifiable;
use App\User;
use App\Services\DogDataService;
use App\Services\ExternalPetApiService;

class NotificationService
{
    public function notifyNextBatchOfEmails($batchCount)
    {
        $emails = User::where('rank', 1)->take($batchCount)->get()->pluck('email')->toArray();
        if (empty($emails)) {
            return true;
        }
        foreach ($emails as $email) {
            $this->sendNotification($email);
            User::where('email', $email)->update(['rank' => 0]);
        }
    }

    public function sendNotification($email)
    {
        $externalPetApiService = new ExternalPetApiService();
        $externalZipApiService = new ExternalZipApiService();
        $dogDataService = new DogDataService($externalPetApiService, $externalZipApiService);
        $user = User::where('email', $email)->first();
        $selection = $user->selection()->first();

        $updatedArray = $dogDataService->getUpdatedBreedArray($email);
        $filteredUpdatedArray = $dogDataService->getRecordsUnderMaxMiles($updatedArray,$selection->max_miles,$selection->zip);
        if (empty($filteredUpdatedArray)) {
            return false;
        } else {
            $dogDataService->addDogsToFoundDogsTable($filteredUpdatedArray, $email);
            $user->notify(new PuppyArrived($user, ['zip' => $selection->zip, 'miles' => $selection->max_miles]));
        }
    }
}

