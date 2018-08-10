<?php

namespace Tests\Unit;

use App\Found_Dog;
use App\Selection;
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
                            ->with('selection')
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
        $user = factory(User::class)->create();
        factory(Found_Dog::class)->create(['email' => $user->email]);
        $userCount = User::all()->count();
        $selectionCount = Selection::all()->count();
        $foundDogCount = Found_Dog::all()->count();
        $this->delete("/user/$user->email");
        $this->assertEquals($userCount - 1,User::all()->count());
        $this->assertEquals($selectionCount - 1,Selection::all()->count());
        $this->assertEquals($foundDogCount - 1,Found_Dog::all()->count());
    }
}
