<?php
namespace App\Services;

Class ExternalZipApiService {

    public function getMilesBetweenZipCodes($zipCodes, $focusZip)
    {
        $client = new \GuzzleHttp\Client();
        $zipDistanceArray = [];
        $zipString = '';
        $index = 0;
        foreach($zipCodes as $zipCode){
            if($index == 0){
                $zipString .= $zipCode['zip'];
            }else{
                $zipString .= ', ' . $zipCode['zip'];
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

    public function getDistanceBetweenTwoZipCodes($homeZip, $destinationZip)
    {
        $fullApiArray = $this->queryGoogleDistanceApi($homeZip,$destinationZip);
        $distance = $this->extractDistanceFromApiArray($fullApiArray);
        return $distance;
    }

    public function queryGoogleDistanceApi($homeZip, $destinationZip)
    {
        $client = new \GuzzleHttp\Client();
        $query = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" .
            "$homeZip&destinations=$destinationZip&key="
            . env('ZIP_API_KEY');
        $queryResponse = $client->request('GET', $query);
        $distanceArray = json_decode($queryResponse->getBody()->getContents(), true);
        return $distanceArray;
    }

    public function extractDistanceFromApiArray($distanceArray){
        $distanceString = $distanceArray['rows']['0']['elements']['0']['distance']['text'];
        $distance = preg_replace("/[^0-9,.]/", "", $distanceString);
        return $distance;
    }
}
