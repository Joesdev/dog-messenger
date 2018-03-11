<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DistanceController extends Controller
{
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

}
