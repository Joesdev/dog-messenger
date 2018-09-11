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
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->service = new UserService();
        $this->seed('usersTableSeeder');
        $this->user = User::firstOrFail();
    }

    public function test_getUserSelection_returns_all_rows()
    {
        $validEmail = $this->user->email;
        $selection = $this->service->getUserSelection($validEmail);
        $this->assertArrayHasKey('zipCode', $selection);
        $this->assertArrayHasKey('miles', $selection);
    }

    public function test_checkUserToken_returns_false_for_an_unmatched_token_and_true_for_matched_token()
    {
        $invalidUserToken = str_random(32);
        $validUserToken = $this->user->token;
        $isTokenValid = $this->service->checkUserToken($invalidUserToken, $this->user->email);
        $this->assertFalse($isTokenValid);
        $isTokenValid = $this->service->checkUserToken($validUserToken, $this->user->email);
        $this->assertTrue($isTokenValid);
    }

    public function test_getUserToken_returns_a_users_token_from_database()
    {
        $email = $this->user->email;
        $token = $this->service->getUserToken($email);
        $this->assertEquals($this->user->token, $token);
    }
}
