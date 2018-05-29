<?php

namespace Tests\Unit;

use App\Found_Dog;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(){
        parent::setUp();
        $this->fillData();
        $this->setRandomUser();
    }

    public function fillData()
    {
        $this->artisan('db:seed');
    }

    public function setRandomUser()
    {
        $this->user = User::where('id', random_int(1,User::count()))
                            ->with('selection.breed')
                            ->first();
    }

    public function test_getUserZip()
    {
        $response = $this->get('user/zip/'.$this->user->email);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'zip'
        ]);
        $response->assertJson(['zip' => $this->user->selection->zip]);

    }

    public function test_getUserBreedName()
    {
        $response = $this->get('user/breed/'.$this->user->email);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'name',
        ]);
        $response->assertJson([
           'name' => $this->user->selection->breed->breed,
        ]);
    }

    public function test_getUserMiles()
    {
        $response= $this->get('user/miles/'.$this->user->email);
        $response->assertStatus(200);
        $response->assertJsonStructure([
           'miles',
        ]);
        $response->assertJson([
            'miles' => $this->user->selection->max_miles,
        ]);
    }

    public function test_destroyUser_removes_user_row_with_selection_row_and_found_dogs_row()
    {
        $validEmail = env('APP_EMAIL');
        factory(User::class)->create(['email' => $validEmail]);
        factory(Found_Dog::class)->create(['email' => $validEmail]);
        $userCount = User::all()->count();
        $selectionCount = Selection::all()->count();
        $foundDogCount = Found_Dog::all()->count();
        //When I call the function with that users email
        $this->post("/user/$email");
        //Then I expect the user table to be truncated by one,same with selection table and no records for found_dogs with that email
        $this->assertEquals($userCount - 1,User::all()->count());
        $this->assertEquals($selectionCount - 1,User::all()->count());
        $this->assertEquals($foundDogCount - 1,User::all(a)->count());
    }
}
