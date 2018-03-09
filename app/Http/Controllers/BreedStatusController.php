<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class BreedStatusController extends Controller
{
    public function getAllBreeds(){
        $breedText = Storage::disk('local')->get('/data/breeds.json');
        $breedArray = json_decode($breedText, true);
        $index = 0;
        // Turns BreedArray from nested to single level array
        foreach($breedArray as $item){
            $breedArray[$index] = $item['$t'];
            $index++;
        };
        return $breedArray;
    }
}
