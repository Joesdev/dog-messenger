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

    public function testFunction(){
        $zipCodes = [
            '91324',
            '95401',
            '91326'
        ];

        $maxMiles = 100;
        $focusZip = '95492';
        $var = $this->getMilesBetweenZipCodes($zipCodes, $maxMiles, $focusZip);
    }
    public function getMilesBetweenZipCodes($zipCodes, $maxMiles, $focusZip)
    {
        $client = new \GuzzleHttp\Client();
        $zipDistanceArray = [];
        $zipString = '';
        $index = 0;
        foreach($zipCodes as $zipCode){
            if($index == 0){
                $zipString .= $zipCode;
            }else{
                $zipString .= ', ' . $zipCode;
            }
            $index++;
        }
        $query = "https://www.zipcodeapi.com/rest/" .  env('ZIP_API_KEY')  . "/multi-distance.json" .
                                "/"         .  $focusZip               . "/"                     .
                           $zipString       .  "/mile"
        ;
        $queryResponse = $client->request('GET', $query);
        dd($queryResponse);
        //format if necessary
        //return data
    }
}
