<?php

namespace App\Http\Controllers;

use App\Selection;
use Illuminate\Http\Request;
use Storage;
use GuzzleHttp\Client;
use App\User;
use App\Breed;
use App\Http\Controllers\DistanceController;

class BreedStatusController extends Controller
{
    private $selectionZipCode;
    private $selectionMaxMiles;
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

    public function getUpdatedBreedArray($email){
        //Retrieves selection values given an email address
        $user = User::where('email', $email)->with('selection')->get();
        $selectionId = $user->pluck('selection_id');
        $selection = Selection::where('id', $selectionId)->get();
        $subset = $selection->map(function ($selection) {
            return collect($selection->toArray())->only(['highest_breed_id','breed_id', 'max_miles', 'zip'])->all();
        });
        $breed_id = $subset->pluck('breed_id')->first();
        $usersMaxId = $subset->pluck('highest_breed_id')->first();
        $breedName = Breed::where('id', $breed_id)->get()->pluck('breed')->first();
        $this->selectionZipCode = $subset->pluck('zip')->first();
        $this->selectionMaxMiles = $subset->pluck('max_miles')->first();
        $breeds = $this->getExternalDataForBreed($this->selectionZipCode, $breedName);
        $latestMaxId = $this->getLargestBreedId($breeds);

        if($latestMaxId > $usersMaxId){
            return $updatedBreedArray = $this->getRecordsLargerThanBreedId($breeds, $usersMaxId);
        }else{
            return [];
        }
    }

    public function testFunction()
    {
        $updatedArray = $this->getUpdatedBreedArray('steve@gmail.com');
        $this->isDistanceUnder($updatedArray);
    }

    public function getRecordsLargerThanBreedId($breedData, $breedId)
    {
        $recordsLargerThanBreedId = [];
        foreach($breedData as $data)
        {
            if($data['id']['$t'] > $breedId){
                array_push($recordsLargerThanBreedId, $data['id']['$t']);
            }
        }
        return $recordsLargerThanBreedId;
    }

    public function sortRecordsIds($breedData){
        $records = [];
        foreach($breedData as $data){
            array_push($records,$data['id']['$t']);
        }
        rsort($records);
        return $records;
    }

    public function isDistanceUnder()
    {

    }

}
