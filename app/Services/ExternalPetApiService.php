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
        foreach($dogData as $dog){
            $masterArrayOfDogs = [
                'bio' => $this->appendDescription($dogData['description']),
                'name' => $dogData['name']['$t'],
                'age'  => $dogData['age']['$t'],
                'size'  => $dogData['size']['$t'],
                'sex'  => $dogData['sex']['$t'],
                'isMix' => $dogData['mix']['$t'],
                'phone' => $dogData['contact']['phone']['$t'],
                'email' => $dogData['contact']['email']['$t'],
                'address' => $dogData['contact']['address1']['$t'],
                'city' => $dogData['contact']['city']['$t'],
                //'distance' => $found_dogs[$index]['miles'] . ' miles',
            ];

            foreach($dogData['media']['photos']['photo'] as $photo){
                if(strpos($photo['$t'], 'width=500')){
                    $masterArrayOfDogs['media'] = $photo['$t'];
                    break;
                }
            };
        }
        dd($masterArrayOfDogs);
    }

    public function appendDescription($description)
    {
        if(empty($description)){
            $description  = 'Not Available';
        } else {
            $description = $description['$t'];
        }
        return $description;
    }

}