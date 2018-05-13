<?php

namespace Tests\Feature;

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
        //Given I have dog data and an id
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

    public function create_mock_dog_data(){
        $dogArray = [];
        for($i=0;$i<50;$i++){
            $dogArray[$i]['id']['$t'] = rand(10000,99999);
            $dogArray[$i]['contact']['zip']['$t'] = rand(91111, 98000);
        }
        return $dogArray;
    }



}
