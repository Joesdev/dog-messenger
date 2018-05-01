<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Selection;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_getUsersZip_returns_valid_zip_code()
    {
        $users = factory(User::class,3)->create()->each(function ($u){
           $u->selection()->save(factory(Selection::class)->make());
        });
        $testEmail = $users[0]['email'];
        $response = $this->get("user/$testEmail/zip");
        $response->assertStatus(200);
        //Then
        //confirm I see json
        //confirm value is what Is expected
    }
}
