<?php


namespace App\Services;


class ExternalApiService
{
    public function getExternalDataForBreed($location, $breed)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'api.petfinder.com/pet.find?' .
            'key=' . env('API_KEY') . '&' .
            'location=' . $location . '&' .
            'breed=' . $breed . '&' .
            'count=100' . '&' .
            'format=json' . '&' .
            'offset=0'
        );
        $data = json_decode($response->getBody()->getContents(), true);
        $data = $data['petfinder']['pets']['pet'];
        return $data;
    }
    public function getExternalDataForSingleDog($petId)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'api.petfinder.com/pet.get?' .
            'key=' . env('API_KEY') . '&' .
            'format=json' . '&' .
            'id=' . $petId
        );
        $data = json_decode($response->getBody()->getContents(), true);
        $data = $data['petfinder']['pet'];
        return $data;
    }

}