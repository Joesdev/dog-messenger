<?php

namespace App\Http\Controllers;

use App\Services\DogDataService;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;
use App\Selection;
use App\User;

class FormController extends Controller
{
    protected $externalApiService;
    protected $dogDataService;
    public function __construct(ExternalApiService $externalApiService, DogDataService $dogDataService)
    {
        $this->externalApiService = $externalApiService;
        $this->dogDataService = $dogDataService;
    }

    public function storeUserSelection(Request $request)
    {
        $zip = $request->zip;
        $breedName = $request->breedName;
        $maxMiles = $request->maxMiles;
        $email = $request->email;

        $breedArray = $this->externalApiService->getExternalDataForBreed($zip,$breedName);
        $selection =
            Selection::create([
                'breed_id' => $this->dogDataService->getBreedId($breedName),
                'zip' => $zip,
                'highest_breed_id' => $this->dogDataService->getLargestBreedId($breedArray),
                'max_miles' => $maxMiles,
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
