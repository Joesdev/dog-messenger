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
















}
