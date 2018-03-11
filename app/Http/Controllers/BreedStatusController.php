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
    }

    public function saveMaxBreedIdToSelectionsTable($email, $breedId)
    {
        $user = User::where('email',$email)->with('selection')->get(['selection_id']);
        $selection_id = $user->pluck('selection_id');
        Selection::where('id', $selection_id)->update([
            'highest_breed_id' => $breedId
        ]);
    }

}
