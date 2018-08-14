<?php

namespace App\Http\Controllers;

use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Selection;
use App\User;
use App\Breed;

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
        $allBreedNames = Breed::all();
        $this->validateLandingForm($request);
        $selection =  $this->storeSelection($request);

        $isSuccessful = $this->storeUser($request,$selection->id);
        if($isSuccessful){
            return view('welcome')->with('allBreedNames', $allBreedNames)
                                       ->with('isSuccessful', true);
        }

        $this->storeUser($request,$selection->id);
      
        $allBreedNames = Breed::all();
        return view('welcome')->with('allBreedNames', $allBreedNames);

    }

    public function validateLandingForm(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'maxMiles'  => 'required|integer|between:1,200',
            'zip'       => 'required|regex:/\b\d{5}\b/'
        ]);
    }

    public function storeSelection(Request $request){
        $breedArray = $this->externalPetApiService->getExternalDataForDogs($request->zip);
        return Selection::create([
            'zip' => $request->zip,
            'highest_breed_id' => $this->dogDataService->getLargestBreedId($breedArray),
            'max_miles' => $request->maxMiles,
            'match'     => false
        ]);
    }

    public function storeUser($request,$selectionId){
        return User::create([
            'rank' => 0,
            'name' => 'user',
            'email' => $request->email,
            'selection_id' => $selectionId,
        ]);
    }

    public function testFunction(){
        $notificationService = new NotificationService();
        $notificationService->notifyNextTwoEmails();
    }

}
