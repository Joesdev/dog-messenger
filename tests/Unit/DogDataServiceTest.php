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
        //Given I have a user row with a related selection row, and that select's highest breed id
            //is somewhat recent
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
        $dogArray = [];
        $highestValue = 100000;
        //Create an array which has random id values, insert a max into a random index
        for($i=0;$i<=50;$i++){
            $dogArray[$i]['id']['$t'] = rand(10000,99999);
        }
        $dogArray[rand(1,50)]['id']['$t'] = $highestValue;
        $returnedMax = $this->dogDataService->getLargestBreedId($dogArray);
        $this->assertEquals($highestValue,$returnedMax);
    }















}
