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
        $this->artisan('db:seed');
        dd(User::all());
       /* $this->selection = factory(Selection::class)->create();*/
        /*$this->user = factory(User::class)->create(['selection_id' => $this->selection->id])*/;
        /*dd(Breed::get(['breed'])->toArray());*/
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
        $response->assertStatus(200);
    }
}
