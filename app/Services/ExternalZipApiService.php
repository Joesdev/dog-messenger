<?php
namespace App\Services;

Class ExternalZipApiService {

    public function getMilesBetweenZipCodes($destZipArray, $homeZip)
    {
        $destZipString = $this->concatStringOfZipCodes($destZipArray);
        $fullApiArray = $this->queryGoogleDistanceApi($homeZip, $destZipString);
        $distanceArray = $this->extractDistanceFromApiArray($fullApiArray);
        $distBetweenZipsArray = array_combine($destZipArray, $distanceArray);
        return $distBetweenZipsArray;
    }

    public function concatStringOfZipCodes($zipCodes)
    {
        $zipString = '';
        $index = 0;
        foreach($zipCodes as $zipCode){
            if($index == 0){
                $zipString .= $zipCode;
            }else{
                $zipString .= '|' . $zipCode;
            }
            $index++;
        }
        return $zipString;
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

    public function extractDistanceFromApiArray($responseArray){
        $distanceArray = [];
        $responseSubArray = $responseArray['rows']['0']['elements'];
        foreach($responseSubArray as $indexArray){
            $distString = $indexArray['distance']['text'];
            $distance = preg_replace("/[^0-9,.]/", "", $distString);
            array_push($distanceArray, $distance);
        }
        return $distanceArray;
    }
}
