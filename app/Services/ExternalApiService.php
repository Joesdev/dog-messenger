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

    public function showCollectedArrayOfDogsView($email)
    {
        $masterArrayOfDogs = [];
        $media = [];
        $index = 0;
        $found_dogs = Found_Dog::where('email', $email)->get();
        $found_dogs = $found_dogs->map(function ($dogs) {
            return collect($dogs->toArray())->only(['new_breed_id','miles'])->all();
        });
        foreach($found_dogs as $dog){
            $tmpDogData = $this->getExternalDataForSingleDog($dog['new_breed_id']);
            foreach($tmpDogData['media']['photos']['photo'] as $photo){
                if(strpos($photo['$t'], 'width=500')){
                    array_push($media, $photo['$t']);
                }
            };

            $masterArrayOfDogs[$index] = [
                'name' => $tmpDogData['name']['$t'],
                'age'  => $tmpDogData['age']['$t'],
                'size'  => $tmpDogData['size']['$t'],
                'sex'  => $tmpDogData['sex']['$t'],
                'bio'  => $tmpDogData['description']['$t'],
                'isMix' => $tmpDogData['mix']['$t'],
                'phone' => $tmpDogData['contact']['phone']['$t'],
                'email' => $tmpDogData['contact']['email']['$t'],
                'address' => $tmpDogData['contact']['address1']['$t'],
                'city' => $city = $tmpDogData['contact']['city']['$t'],
                'distance' => $found_dogs[$index]['miles'] . ' miles',
                'media' => $media
            ];
            $media = [];
            $index++;
        }
        return view('results')->with('dogData' ,$masterArrayOfDogs);
    }

}