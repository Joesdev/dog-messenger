<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use GuzzleHttp\Client;
use App\Selection;
use App\User;

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

    public function saveUserRecordToEmail($email, $miles, $breed){
        $selection =
            Selection::create([
                'breed_id' => $this->getBreedIdForDatabase($breed),
                'highest_breed_id' => 0,
                'max_miles' => $miles,
                'match'     => false
            ])
        ;

        User::create([
            'rank' => 0,
            'name' => 'user',
            'email' => $email,
            'selection_id' => $selection->id,

        ]);
    }

   /* public function testFunction(){
        $email = 'joey4favre@gmail.com';
        $miles = 75;
        $breed = 'Pit Bull Terrier';
        dd($this->saveUserRecordToEmail($email, $miles, $breed));
    }*/

    public function getBreedIdForDatabase($breedName){
        $breedText = Storage::disk('local')->get('/data/breeds.json');
        $breedArray = json_decode($breedText, true);
        $index = 1;
        foreach($breedArray as $breed){
            if($breedName === $breed){
                return $index;
            } else{
                $index++;
            }
        };
        return 0;
    }

}
