<?php


namespace App\Services;


class ExternalPetApiService
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
        $this->getSlimData($data);
        return $data;
    }

    public function getSlimData($dogData)
    {

            $dogData['mix'] = [];
            //dd($dogData);
            $masterArrayOfDogs = [
                'description' => $this->validateKey('description', $dogData),
                'name' => $this->validateKey('name', $dogData),
                'age'  => $this->validateKey('age', $dogData),
                'size'  => $this->validateKey('size', $dogData),
                'sex'  => $this->validateKey('sex', $dogData),
                'mix' => $this->validateKey('mix', $dogData)
                /*'phone' => $dogData['contact']['phone']['$t'],
                'email' => $dogData['contact']['email']['$t'],
                'address' => $dogData['contact']['address1']['$t'],
                'city' => $dogData['contact']['city']['$t'],*/
                //'distance' => $found_dogs[$index]['miles'] . ' miles',
            ];

            /*foreach($dogData['media']['photos']['photo'] as $photo){
                if(strpos($photo['$t'], 'width=500')){
                    $masterArrayOfDogs['media'] = $photo['$t'];
                    break;
                }
            };*/
            dd($masterArrayOfDogs);

    }

    public function validateKey($key, $data)
    {
        $accepted_keys = ['age','description','mix','name','sex','size'];
        if(in_array($key, $accepted_keys, true)) {
            if(!empty($data[$key])){
                return $data[$key]['$t'];
            } else {
                return 'Not Available';
            }
        }
    }

    public function validateContactKey($key, $data)
    {

    }

}