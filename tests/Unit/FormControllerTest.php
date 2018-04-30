<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Selection;

class FormControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_StoreUsersSelection_RequiresValidEmail()
    {
        $this->sendForm(['email' => ''])->assertSessionHasErrors('email');
        $this->sendForm(['email' => 'johndoe'])->assertSessionHasErrors('email');
    }

    public function test_StoreUsersSelection_RequiresValidMaxMiles()
    {
        $this->sendForm(['maxMiles' => 201])->assertSessionHasErrors('maxMiles');
        $this->sendForm(['maxMiles' => 0])->assertSessionHasErrors('maxMiles');
        $this->sendForm(['maxMiles' => '0'])->assertSessionHasErrors('maxMiles');
        $this->sendForm(['maxMiles' => ''])->assertSessionHasErrors('maxMiles');
    }

    public function test_StoreUsersSelection_RequiresValidZip()
    {
        $this->sendForm(['zip' => 9549])->assertSessionHasErrors('zip');
        $this->sendForm(['zip' => 954921])->assertSessionHasErrors('zip');
        $this->sendForm(['zip' => ''])->assertSessionHasErrors('zip');
    }

    public function test_StoreUsersSelection_RequiresValidBreedName()
    {
        $this->sendForm(['breedName' => 'notarealbreed'])->assertSessionHasErrors('breedName');
        $this->sendForm(['breedName' => ''])->assertSessionHasErrors('breedName');
    }

    public function test_StoreUsersSelection_StoresUser()
    {
        factory(Selection::class, 3)->create()->each(function($selection){
            $selection->users()->save(factory(User::class)->make([
                'selection_id' => $selection->id
            ]));
        });
        $this->sendForm();
        $this->assertCount(4,User::all());
    }
    // --------------------------------- Helper Functions -------------------------------------------
    protected function sendForm($attributes = [])
    {
        $this->withExceptionHandling();
        return $this->post('/user-selections',$this->validFields($attributes));
    }

    protected function validFields($overrides = [])
    {
        return array_merge([
            'email' => 'johndoe@gmail.com',
            'maxMiles' => 75,
            'zip' => 95492,
            'breedName' => 'Akita'
        ], $overrides);
    }
}
