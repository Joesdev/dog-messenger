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
        $zipDistanceArray = json_decode($queryResponse ->getBody()->getContents(), true);
        return $zipDistanceArray['distances'];
    }

    public function getExternalDataForBreed(Request $request)
    {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'api.petfinder.com/pet.find?' .
                'key=' . env('API_KEY') . '&' .
                'location=' . $request->location . '&' .
                'breed=' . $request->breed . '&' .
                'count=100' . '&' .
                'format=json' . '&' .
                'offset=0'
            );
            $data = json_decode($response->getBody()->getContents(), true);
            $data = $data['petfinder']['pets']['pet'];
            return $data;
    }

    public function saveUserRecordToEmail($email, $zip, $breed){
    //  Save the email to DB
    //  Save Breed Preference to DB
    //  Save the largest petID to DB
    //  Save milage to DB
    }

}
