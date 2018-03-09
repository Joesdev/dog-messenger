<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\BreedStatusController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getHomeView(){
        $breedStatusController = new BreedStatusController();
        $allBreeds = $breedStatusController->getAllBreeds();
        return view('welcome')->with('allBreeds',$allBreeds);
    }
}
