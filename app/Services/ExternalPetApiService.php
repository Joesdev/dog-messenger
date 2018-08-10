<?php


namespace App\Services;
use App\Exceptions\IndexException;
use App\Exceptions\InvalidPetIdException;

class ExternalPetApiService
{
    private $countOfDogsRequested = 75;


    public function getExternalDataForDogs($location)
    {
        $data = $this->getRawDogApiData($location);
        $data = $this->validateDogData($data);
        return $data;
    }

    public function getRawDogApiData($location){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'api.petfinder.com/pet.find?' .
            'key=' . env('API_KEY') . '&' .
            'location=' . $location . '&' .
            'animal=dog&' .
            'age=Baby&' .
            'count='.$this->countOfDogsRequested. '&' .
            'format=json' . '&' .
            'offset=0'
        );
        $data = json_decode($response->getBody()->getContents(), true);
        return $data;
    }

    public function validateDogData($data){
        dd($data);
        if(isset($data['petfinder']['pets']['pet'])){
            return $data['petfinder']['pets']['pet'];
        }else{
            throw new IndexException;
        }
    }

    public function validateGeographicLocation($apiDogArray)
    {
        
    }

    public function getCount(){
        return $this->countOfDogsRequested;
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
        if($this->getStatusCode($data) == 201){
            throw new InvalidPetIdException('The pet id no longer exists');
        }
        if(array_key_exists('pet' ,$data['petfinder'])){
            return $data = $this->getSlimDogData($data['petfinder']['pet']);
        } else{
            return $data = [];
        }
    }

    public function getStatusCode($data){
        if(isset($data['petfinder']['header']['status']['code']['$t'])) {
            return $data['petfinder']['header']['status']['code']['$t'];
        }else{
            throw new IndexException;
        }
    }

    public function getSlimDogData($dogData)
    {
            $masterArrayOfDogs = [
                'name'        => $this->validateKey('name', $dogData),
                'age'         => $this->validateKey('age', $dogData),
                'size'        => $this->validateKey('size', $dogData),
                // Convert M/F to Male/Female if validation passes
                'sex'         => $this->appendSexString($this->validateKey('sex', $dogData)),
                'mix'         => $this->validateKey('mix', $dogData),
                'description' => $this->validateKey('description', $dogData),
                'phone'       => $this->validateContactKey('phone', $dogData),
                'email'       => $this->validateContactKey('email', $dogData),
                'address'     => $this->validateContactKey('address1', $dogData),
                'city'        => $this->validateContactKey('city', $dogData),
                'state'       => $this->validateContactKey('state', $dogData),
                'zip'         => $this->validateContactKey('zip', $dogData),
                'media'       => $this->validateMediaKey(500, $dogData)
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
        $accepted_keys = ['address1','city','email','phone', 'state', 'zip'];
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

    public function appendSexString($sex)
    {
        if($sex === 'Not Available'){
            //Do Nothing
        } else if(ucwords($sex) === 'F'){
            $sex = 'Female';
        } else {
            $sex = 'Male';
        }
        return $sex;
    }

}