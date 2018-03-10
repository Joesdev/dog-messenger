<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use GuzzleHttp\Client;

class BreedStatusController extends Controller
{
    public function getAllBreeds(){
        $breedText = Storage::disk('local')->get('/data/breeds.json');
        $breedArray = json_decode($breedText, true);
        return $breedArray;
    }

/*    public function getZipCodesByDistance(Request $request)
    {
        $index = 0;
        //query for all zip codes
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
    public function getMilesBetweenZipCodes($zipCodes, $maxMiles, $focusZip)
    {
        $client = new \GuzzleHttp\Client();
        $zipDistanceArray = [];
        $zipString = '';
        foreach($zipCodes as $zipCode){
            $zipString += ', ' . $zipCode;
        }
        dd($zipString);
        //create string to Query Zip Codes API using both query string and maxMiles
        $query = 'www.zipcodeapi.com/rest/' .  env('ZIP_API_KEY')  . '/multi-distance.json/' .
                                '/'         .  $focusZip               . '/'                     .
                           $zipString       .  '/mile'
        ;
        //query, save to variable
        //format if necessary
        //return data
    }
}
