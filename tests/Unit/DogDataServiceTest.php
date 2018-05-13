<?php

namespace Tests\Feature;

use App\Found_Dog;
use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use App\Services\ExternalZipApiService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Selection;

class DogDataServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $petApiService;
    protected $zipApiService;
    protected $dogDataService;

    public function setUp(){
        parent::setUp();
        $this->petApiService = new ExternalPetApiService();
        $this->zipApiService = new ExternalZipApiService();
        $this->dogDataService = new DogDataService($this->petApiService, $this->zipApiService);
    }
    public function test_getUpdatedBreedArray_returns_multiple_arrays_of_new_dogs()
    {
        $this->seed('breedsTableSeeder');
        $user = factory(User::class)->create();
        Selection::find($user->id)->update([
            'breed_id'         => 5,
            'zip'              => 95492,
            'highest_breed_id' => 41610500,
            'max_miles'        => 75
        ]);
        $dogData = $this->dogDataService->getUpdatedBreedArray($user->email);
        $this->assertGreaterThanOrEqual(1,count($dogData));
    }

    public function test_updateHighestBreedId_sets_id_of_selections_table_to_provided_number(){
        $insertedBreedId = 41000000;
        $selection = factory(Selection::class)->create();
        $this->dogDataService->updateHighestBreedId($selection->id,$insertedBreedId);
        $this->assertDatabaseHas('selections', [
            'id' => $selection->id,
            'highest_breed_id' => $insertedBreedId,
        ]);
    }

    public function test_getLargestBreedId_returns_largest_id(){
        $highestValue = 100001;
        //Create an array which has random id values, insert a max into a random index
        $dogArray = $this->create_mock_dog_data();
        $dogArray[rand(1,50)]['id']['$t'] = $highestValue;
        $returnedMax = $this->dogDataService->getLargestBreedId($dogArray);
        $this->assertEquals($highestValue,$returnedMax);
    }

    public function test_getRecordsLargerThanBreedId_returns_records_larger_than_provided_id(){
        $dogData = $this->create_mock_dog_data();
        //Insert 3 id's which are higher than the max id in the array
        $index = rand(1,20);
        $dogData[$index]['id']['$t'] = rand(100000,100100);
        $dogData[$index + 5]['id']['$t'] = rand(100200,100500);
        $dogData[$index + 10]['id']['$t'] = rand(100600,100700);
        $recordsAboveMax = $this->dogDataService->getRecordsLargerThanBreedId($dogData, 100000);
        //assert that the 3 'above max' id's are returned from the function
        $this->assertEquals(3, count($recordsAboveMax));
    }

    public function test_sortRecordsIds_returns_flattened_array_in__desc_order(){
        $dogData = $this->create_mock_dog_data();
        $sortedIds = $this->dogDataService->sortRecordsIds($dogData);
        $isSorted = $this->isIdArraySortedByDesc($sortedIds);
        $this->assertEquals(true,$isSorted);
    }

    public function test_addDogsToFoundDogsTable_stores_records_in_database(){
        $data = $this->create_mock_updated_dog_data();
        $this->dogDataService->addDogsToFoundDogsTable($data,'test@email.com');
        foreach($data as $row){
            $this->assertDatabaseHas('found_dogs',[
                'email'        => 'test@email.com',
                'new_breed_id' => $row['id'],
                'miles'        => $row['distance']
            ]);
        };
    }

    //Caution Api Call is Metered to 50/hour, this function makes 6 api calls
    /*public function test_getRecordsUnderMaxMiles_returns_only_arrays_with_distance_under_max_miles(){
        $maxMiles = 100;
        $zip = 95492;
        $updatedDogData = $this->create_mock_updated_dog_data(false);
        $distanceData = $this->dogDataService->getRecordsUnderMaxMiles($updatedDogData, $maxMiles, $zip);
        $this->assertCount(2,$distanceData);
        $this->assertArrayHasKey('distance',$distanceData[0]);
        $distanceData = $this->dogDataService->getRecordsUnderMaxMiles($updatedDogData, $maxMiles = 35, $zip);
        $this->assertCount(1,$distanceData);
    }*/

    public function test_resetUsersToRankOne_updates_rank_column_to_one_in_all_database_rows(){
        factory(User::class,10)->create();
        $this->dogDataService->resetUsersToRankOne();
        $this->assertDatabaseMissing('Users',[
            'rank' => 0
        ]);
    }

    public function create_mock_updated_dog_data($includeDistance=true){
        $zips = ['95422','95423','91324'];
        $ids = [41612837,41619827,41615837];
        $distance = [33,39,380];
        for($i=0;$i<3;$i++){
            $data[$i]['id'] = $ids[$i];
            $data[$i]['zip'] = $zips[$i];
            if($includeDistance == true){
                $data[$i]['distance'] = $distance[$i];
            }
        }
        return $data;
    }

    public function create_mock_dog_data($count = 50){
        $dogArray = [];
        for($i=0;$i<$count;$i++){
            $dogArray[$i]['id']['$t'] = rand(10000,99999);
            $dogArray[$i]['contact']['zip']['$t'] = rand(91111, 98000);
        }
        return $dogArray;
    }

    public function isIdArraySortedByDesc($idArray){
        $flag = true;
        $lastVal = $idArray[0];
        foreach($idArray as $value){
            if($value > $lastVal) {
                $flag = false;
                break;
            } else{
                $lastVal = $value;
            }
        }
        return $flag;
    }
}
