<?php

namespace Tests\Feature;

use App\Found_Dog;
use App\User as UserModel;
use App\Selection as SelectionModel;

use App\Http\Controllers\BreedController;
use Tests\TestCase;
use App\Services\UserService as UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BreedControllerTest extends TestCase
{
    use refreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $user;
    protected $email = 'joesilvpb4@gmail.com';
    protected $invalidEmail = 'notreal@gmail.com';
    protected $breedController;

    public function setUp(){
        parent::setUp();
        $this->seed('found_dogsTableSeeder');
        $this->user = factory(UserModel::class,1)->create(['email' => $this->email])->first();
        $this->breedController = new BreedController(new UserService());
    }

    public function test_showCollectedArrayOfDogsView_returns_view_with_data_from_found_dogs_table()
    {
        $countOfRows = Found_Dog::whereEmail($this->email)->count();
        $response = $this->get('/results/'.$this->email.'/'.$this->user->token);
        $data = $response->getOriginalContent()->getData();
        $this->assertCount($countOfRows,$data['dogData']);
        $this->assertArrayHasKey('userSelection', $data);
    }

    public function test_showCollectedArrayOfDogsView_returns_welcome_view_when_token_is_invalid()
    {
        $invalid_token = str_random(32);
        $response = $this->get('/results/'.$this->email.'/'.$invalid_token);
        $response->assertRedirect('/');
    }

}
