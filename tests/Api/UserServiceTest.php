<?php

namespace Tests\Feature;

use App\Found_Dog;
use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use App\Services\ExternalZipApiService;
use App\Services\UserService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Selection;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new UserService();
        $this->seed('usersTableSeeder');
    }
    public function test_getUserSelection_returns_all_rows()
    {
        $validEmail = User::firstOrFail()->email;
        $selection = $this->service->getUserSelection($validEmail);
        $this->assertArrayHasKey('zipCode', $selection);
        $this->assertArrayHasKey('miles', $selection);
    }
}
