<?php


namespace Tests\Unit;

use App\Found_Dog;
use App\Services\FoundDogsService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoundDogsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleteRecord_removes_correct_amount_of_records()
    {
        $service = new FoundDogsService();
        $found_dog = factory(Found_Dog::class,3)->create()->first();
        $service->deleteRecord($found_dog->new_breed_id);
        $this->assertCount(2, Found_Dog::all());
    }
}