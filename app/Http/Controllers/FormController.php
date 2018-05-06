<?php

namespace App\Http\Controllers;

use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Selection;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FormController extends Controller
{
    protected $externalPetApiService;
    protected $dogDataService;

    public function __construct(ExternalPetApiService $externalPetApiService, DogDataService $dogDataService)
    {
        $this->externalPetApiService = $externalPetApiService;
        $this->dogDataService = $dogDataService;
    }

    public function storeUserSelection(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'maxMiles'  => 'required|integer|between:1,200',
            'zip'       => 'required|regex:/\b\d{5}\b/',
            'breedName' => [
                'required',
                Rule::in(json_decode(Storage::disk('local')->get('/data/breeds.json')))
            ]
        ]);

        $breedArray = $this->externalPetApiService->getExternalDataForBreed($request->zip,$request->breedName);
        $selection =
            Selection::create([
                'breed_id' => $this->dogDataService->getBreedId($request->breedName),
                'zip' => $request->zip,
                'highest_breed_id' => $this->dogDataService->getLargestBreedId($breedArray),
                'max_miles' => $request->maxMiles,
                'match'     => false
            ])
        ;

        User::create([
            'rank' => 0,
            'name' => 'user',
            'email' => $request->email,
            'selection_id' => $selection->id,
        ]);
    }

    public function testFunction(){
        $notificationService = new NotificationService();
        $notificationService->notifyNextTwoEmails();
    }

}
