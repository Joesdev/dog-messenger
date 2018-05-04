<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Selection;
use App\Breed;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $selection;

    public function setUp(){
        parent::setUp();
        $this->runFactories();
    }

    public function runFactories()
    {
        factory(User::class,3)->create()->each(function ($u){
            $u->selection()->save(factory(Selection::class)->make());
        });
        $this->selection = factory(Selection::class)->create();
        $this->user = factory(User::class)->create(['selection_id' => $this->selection->id]);
        $this->seed('BreedsTableSeeder', ['database' =>'testing_mysql']);
    }

    public function test_getUsersZip()
    {
        $response = $this->get('user/zip/'.$this->user->email);
        $response->assertJson(['zip' => $this->selection->zip]);
        $response->assertStatus(200);
    }

    public function test_getUserBreedName()
    {
        dd(Breed::where('id',1)->first());
        $response = $this->json('GET', 'user/breed/'.$this->user->email);
        dd($response);
        $response->assertStatus(200);
    }
}
