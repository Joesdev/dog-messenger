<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormControllerTest extends TestCase
{

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
        // Given - My database has two users
        // When - I store another User
        // Then - The user exists and count is 3
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
