<?php
namespace App\Services;

use App\User;
use App\Breed;
use App\Selection;
use App\Found_Dog;

class DogDataService
{
    protected $externalApiService;
    protected $externalPetApiService;

    public function __construct(ExternalPetApiService $externalPetApiService, ExternalZipApiService $externalZipApiService){
        $this->externalPetApiService = $externalPetApiService;
        $this->externalZipApiService = $externalZipApiService;
    }

    public function getUpdatedBreedArray($email){
        $selection = User::whereEmail($email)->with('selection')->firstOrFail()->selection;
        $breedName = Breed::find($selection->breed_id)->breed;
        $breeds = $this->externalPetApiService->getExternalDataForBreed($selection->zip, $breedName);
        $latestMaxId = $this->getLargestBreedId($breeds);

        $this->updateHighestBreedId($selection->id, $latestMaxId);

        if($latestMaxId > $selection->highest_breed_id){
            return $updatedBreedArray = $this->getRecordsLargerThanBreedId($breeds, $selection->highest_breed_id);
        }else{
            return [];
        }
    }

    public function updateHighestBreedId($selectionId, $maxId)
    {
        $selection = Selection::where('id',$selectionId)->first();
        $selection->highest_breed_id = $maxId;
        $selection->save();
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

    public function getRecordsLargerThanBreedId($breedData, $breedId)
    {
        $recordsLargerThanBreedId = [];
        foreach($breedData as $data)
        {
            if($data['id']['$t'] > $breedId){
                $item = array(
                    'id' => $data['id']['$t'],
                    'zip' => $data['contact']['zip']['$t']
                );
                $recordsLargerThanBreedId[] = $item;
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

    public function addDogsToFoundDogsTable($dogData, $email){
        foreach($dogData as $dog){
            $found_dogs = new Found_Dog();
            $found_dogs->email = $email;
            $found_dogs->new_breed_id = $dog['id'];
            $found_dogs->miles = $dog['distance'];
            $found_dogs->save();
        }
    }

    public function getRecordsUnderMaxMiles($breedArray,$maxMiles, $zipCode)
    {
        $index = 0;
        if(empty($breedArray)){
            return [];
        }
        $arrayOfZipCodes = $this->extractDogDataByKey('zip', $breedArray);
        $distanceArray = $this->externalZipApiService->getMilesBetweenZipCodes($arrayOfZipCodes, $zipCode);
        /*$distanceArray = [
            '95462' => 11.591,
            '95828' => 77.12,
            '90248' => 408775
        ];*/
        //Remove any breed data from array that is under max miles
        foreach($breedArray as $breed){
            $zip = $breed['zip'];
            if($distanceArray[$zip] > $maxMiles){
                unset($breedArray[$index]);
            } else{
                $breedArray[$index]['distance'] = $distanceArray[$zip];
            }
            $index++;
        }
        return $breedArray;

    }

    public function extractDogDataByKey($key, $dogData)
    {
        $stringOfZipCodes = [];
        foreach($dogData as $data){
            array_push($stringOfZipCodes, $data[$key]);
        }
        return $stringOfZipCodes;
    }

    public function getBreedId($breedName){
        $breedId = Breed::where('breed', $breedName)->pluck('id')->first();
        if(is_null($breedId)){
            return false;
        }
        return $breedId;
    }

    //This function resets all rows to rank 1, rank 1 allows a single row to be eligible
    //for checking for news dogs and to be potentially notified if a new dog is found. Rank
    //0 means a row is not eligible
    public function resetUsersToRankOne(){
        $users = User::where('rank', 0)->update(['rank' => 1]);
    }
}