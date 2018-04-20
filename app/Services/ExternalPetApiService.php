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
        if(array_key_exists('pet' ,$data['petfinder'])){
            return $data = $this->getSlimDogData($data['petfinder']['pet']);

        } else{
            return $data = [];
        }
    }

    public function getSlimDogData($dogData)
    {
            $masterArrayOfDogs = [
                'name'        => $this->validateKey('name', $dogData),
                'age'         => $this->validateKey('age', $dogData),
                'size'        => $this->validateKey('size', $dogData),
                'sex'         => $this->validateKey('sex', $dogData),
                'mix'         => $this->validateKey('mix', $dogData),
                'description' => $this->validateKey('description', $dogData),
                'phone'       => $this->validateContactKey('phone', $dogData),
                'email'       => $this->validateContactKey('email', $dogData),
                'address'     => $this->validateContactKey('address1', $dogData),
                'city'        => $this->validateContactKey('city', $dogData),
                'state'       => $this->validateContactKey('state', $dogData),
                'media'       => $this->validateMediaKey(500, $dogData),
                //'distance'   => $found_dogs[$index]['miles'] . ' miles',
            ];

            return $masterArrayOfDogs;

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
        $accepted_keys = ['address1','city','email','phone', 'state'];
        if(in_array($key, $accepted_keys, true)) {
            if(!empty($data['contact'][$key])){
                return $data['contact'][$key]['$t'];
            } else {
                return 'Not Available';
            }
        }
    }

    public function validateMediaKey($width, $data)
    {
        if(!empty($data['media']['photos']['photo'])) {
            foreach ($data['media']['photos']['photo'] as $photo) {
                if (strpos($photo['$t'], 'width=' . $width)) {
                    return $photo['$t'];
                }
            };
        }
        return '#';
    }

}