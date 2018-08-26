<?php


namespace Tests\Unit;

use App\Found_Dog;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoundDogsServiceTest extends TestCase
{
    public function test_deleteRecord_removes_correct_amount_of_records()
    {
        //Given I have records in the found dogs table
        $found_dogs = factory(Found_Dog::class,3)->create();
        //When I call the function
        //Then I should have the initial count less the amount of deleted records
    }
}