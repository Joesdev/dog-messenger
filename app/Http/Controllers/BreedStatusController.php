<?php

namespace App\Http\Controllers;

use App\Selection;
use Illuminate\Http\Request;
use Storage;
use GuzzleHttp\Client;
use App\User;

class BreedStatusController extends Controller
{
    public function getAllBreeds(){
        $breedText = Storage::disk('local')->get('/data/breeds.json');
        $breedArray = json_decode($breedText, true);
        return $breedArray;
    }

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

    public function getLargestBreedId($breedsArray){
        $max = 0;
        foreach($breedsArray as $breed){
            $id = $breed['id']['$t'];
            if($id > $max){
                $max = $id;
            }
        };
        return $max;
    }

    public function saveMaxBreedIdToSelectionsTable($email, $breedId)
    {
        $user = User::where('email',$email)->with('selection')->get(['selection_id']);
        $selection_id = $user->pluck('selection_id');
        Selection::where('id', $selection_id)->update([
            'highest_breed_id' => $breedId
        ]);
    }

    public function getUpdatedBreedDataForUser($email)
    {
        //query for breed of 100 records
        //getLargestBreedId
        // if greater than users highest_breed_id
            //get an array of all ids larger than highest_breed_id
        // else return
    }

    public function isBreedDataUpdated($email='bullshit0@gmail.com'){
        $user = User::where('email', $email)->with('selection')->get();
        $selectionId = $user->pluck('selection_id');
        $selection = Selection::where('id', $selectionId)->get();
        $subset = $selection->map(function ($selection) {
            return collect($selection->toArray())->only(['highest_breed_id','breed_id', 'max_miles'])->all();
        });
        $this->getExternalDataForBreed()

        //query for 100 records
        //getLargestBreedId on 100 records save to variable
        // if(maxVarialbe > user db high_breed_id)
            //return true;
        // else return false
    }

}
