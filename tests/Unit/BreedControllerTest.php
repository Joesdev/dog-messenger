<?php

namespace Tests\Feature;

use App\Found_Dog;
use App\Http\Controllers\BreedController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BreedControllerTest extends TestCase
{
    use refreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $email = 'joesilvpb4@gmail.com';
    protected $invalidEmail = 'notreal@gmail.com';
    protected $breedController;

    public function setUp(){
        parent::setUp();
        $this->seed('found_dogsTableSeeder');
        $this->breedController = new BreedController();
    }

    public function test_showCollectedArrayOfDogsView_returns_view_with_data_from_found_dogs_table()
    {   $countOfRows = Found_Dog::whereEmail($this->email)->count();
        $response = $this->get('/results/'.$this->email);
        $data = $response->getOriginalContent()->getData();
        $this->assertCount($countOfRows,$data['dogData']);
    }

    public function test_redirectInvalidEmail_redirects_to_home_page_when_email_is_not_in_found_dogs_table()
    {
        $response = $this->get('/results/'.$this->invalidEmail);
        $response->assertViewIs('.welcome');
    }
}
