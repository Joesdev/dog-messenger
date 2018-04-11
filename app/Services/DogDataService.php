<?php
namespace App\Services;

use Storage;
use App\Services\ExternalApiService;
use App\User;
use App\Breed;
use App\Selection;
use App\Found_Dog;

class DogDataService
{
    private $selectionZipCode;
    private $selectionMaxMiles;

    protected $externalApiService;

    public function __construct(ExternalApiService $externalApiService){
        $this->externalApiService = $externalApiService;
    }

    public function getUpdatedBreedArray($email){
        //Get User matching email address
        $user = User::where('email', $email)->with('selection')->get();
        $selectionId = $user->pluck('selection_id');
        //Get Selection based on User's Selection Id
        $selection = Selection::where('id', $selectionId)->get();
        //Save four column values
        $subset = $selection->map(function ($selection) {
            return collect($selection->toArray())->only(['highest_breed_id','breed_id', 'max_miles', 'zip'])->all();
        });
        //Pluck four column values,
        $breed_id = $subset->pluck('breed_id')->first();
        $usersMaxId = $subset->pluck('highest_breed_id')->first();
        $this->selectionZipCode = $subset->pluck('zip')->first();
        $this->selectionMaxMiles = $subset->pluck('max_miles')->first();
        //The reason for this pluck is that we must convert the breed_id to a string of breed name
        $breedName = Breed::where('id', $breed_id)->get()->pluck('breed')->first();

        $breeds = $this->externalApiService->getExternalDataForBreed($this->selectionZipCode, $breedName);
        $latestMaxId = $this->getLargestBreedId($breeds);

        $this->updateHighestBreedId($selectionId, $latestMaxId);

        if($latestMaxId > $usersMaxId){
            return $updatedBreedArray = $this->getRecordsLargerThanBreedId($breeds, $usersMaxId);
        }else{
            return [];
        }
    }

    public function updateHighestBreedId($selectionId, $maxId)
    {
        $selection = Selection::find($selectionId);
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

    public function getRecordsUnderMaxMiles($breedArray)
    {
        $index = 0;
        if(empty($breedArray)){
            return [];
        }
        $distanceArray = $this->externalApiService->getMilesBetweenZipCodes($breedArray, $this->selectionZipCode);
        /*$distanceArray = [
            '92585' => 456.437,
        ];*/
        //Remove any breed data from array that is under max miles
        foreach($breedArray as $breed){
            $zip = $breed['zip'];
            if($distanceArray[$zip] > $this->selectionMaxMiles){
                unset($breedArray[$index]);
            } else{
                $breedArray[$index]['distance'] = $distanceArray[$zip];
            }
            $index++;
        }
        return $breedArray;

    }

    public function getAllBreeds(){
        $breedText = Storage::disk('local')->get('/data/breeds.json');
        $breedArray = json_decode($breedText, true);
        return $breedArray;
    }

    public function getBreedId($breedName){
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