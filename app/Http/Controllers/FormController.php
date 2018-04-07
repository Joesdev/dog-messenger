<?php

namespace App\Http\Controllers;

use App\Services\DogDataService;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;
use App\Selection;
use App\User;
use App\Http\Controllers\BreedController;

class FormController extends Controller
{
    protected $externalApiService;
    protected $dogDataService;
    public function __construct(ExternalApiService $externalApiService, DogDataService $dogDataService)
    {
        $this->externalApiService = $externalApiService;
        $this->dogDataService = $dogDataService;
    }

    public function saveUserRecordToEmail($email='etha2@gmail.com', $miles=44, $breed='Bearded Collie', $zip = "91306"){
        $breedArray = $externalApiService->getExternalDataForBreed($zip,$breed);
        $selection =
            Selection::create([
                'breed_id' => $dogDataService->getBreedId($breed),
                'zip' => $zip,
                'highest_breed_id' => $dogDataService->getLargestBreedId($breedArray),
                'max_miles' => $miles,
                'match'     => false
            ])
        ;

        User::create([
            'rank' => 0,
            'name' => 'user',
            'email' => $email,
            'selection_id' => $selection->id,

        ]);
    }

}
