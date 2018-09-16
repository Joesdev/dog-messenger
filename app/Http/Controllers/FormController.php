<?php

namespace App\Http\Controllers;

use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Selection;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Exception;

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
        $this->validateLandingForm($request);
        if($this->checkHoneyPot($request)){
            return redirect('/');
        };
        $isSuccessful = $this->storeUserWithSelection($request);
        if($isSuccessful){
            return redirect('/')->with('isSuccessful', true);
        }
    }

    public function validateLandingForm(Request $request)
    {

        $request->validate([
            'email'     => 'required|email|unique:users',
            'maxMiles'  => 'required|integer|between:1,200',
            'zip'       => 'required|regex:/\b\d{5}\b/'
        ]);
    }

    public function storeUserWithSelection(Request $request)
    {
        $breedArray = $this->externalPetApiService->getExternalDataForDogs($request->zip);
        $selection = new Selection([
            'zip' => $request->zip,
            'highest_breed_id' => $this->dogDataService->getLargestBreedId($breedArray),
            'max_miles' => $request->maxMiles,
            'match'     => false
        ]);
        $user = new User([
            'rank'  => 0,
            'name'  => 'user',
            'email' => $request->email,
            'token' => str_random(32)
        ]);
        try {
            DB::transaction(function() use ($selection, $user){
                $selection->save();
                $user->selection_id = $selection->id;
                $user->save();
            });
        } catch (Exception $error){
            return false;
        }
        return true;
    }

    public function checkHoneyPot(Request $request)
    {
        $honeyPot = $request->akbar;
        if(!is_null($honeyPot)){
            Log::notice('Honeypot Activated');
            return true;
        } else {
            return false;
        }
    }

}
