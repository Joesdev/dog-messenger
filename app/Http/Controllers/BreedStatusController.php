<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class BreedStatusController extends Controller
{
    public function getAllBreeds(){
        $breedText = Storage::disk('local')->get('/data/breeds.json');
        $breedArray = json_decode($breedText, true);
        return $breedArray;
    }

/*    public function getZipCodesByDistance($mainZip, $zipCodeArray)
    {
        $index = 0;
        foreach($zipCodeArray as $focusZip){
            if(compare focusZip with the index of mainZip){
                //add to the returnable array
            }else{
                //else do nothing
            }
        }
        //return array of new zips
    }
    */
    public function getMilesBetweenZipCodes($zipCodes, $maxMiles)
    {
        //create guzzle object
        //create empty return array
        //Concatenate zipCodes Array into a queryable string
        //create string to Query Zip Codes API using both query string and maxMiles
        //query, save to variable
        //format if necessary
        //return data
    }
}
