<?php

namespace Tests\Unit;

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
}
