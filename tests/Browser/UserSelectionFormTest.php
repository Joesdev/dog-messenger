<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserSelectionFormTest extends DuskTestCase
{

    /*public function test_StoreUsersSelection_RejectsEmptyInputFields()
    {
        $this->browse(function ($browser){
            $browser->visit('/user-selections')
                ->press('submit')
                //When request is rejected, returns user to same page
                ->assertPathIs('/user-selections');
        });
        //(validation is working)
        //check empty email throws error
        //check empty miles throws error
        //check miles outside allowed range throws error
        //check miles inputted as string throws error
        //check empty zip throws error
        //check zipcode less than 5 digits throws error
        //checking zipcode over 5 digits throws error
        //check empty breedname throws error
        //check a breed name not matching listed ones throws error
    }

    public function test_StoreUserSelection_RejectsInvalidEmailInput()
    {
        $this->browse(function ($browser){
           $browser->visit('/user-selections')
                   ->type('email', '')->press('submit')->assertSee('The email field is required.')
                   ->type('email', 'johndoe')->press('submit')->assertPathIs('/user-selections')
                   ->type('email', 'johndoe@gmail')->press('submit')->assertSee('The email must be a valid email address.');
        });
    }

    public function test_StoreUserSelection_RejectsInvalidMaxMilesInput()
    {
        $this->browse(function ($browser){
            $browser->visit('/user-selections')
                ->type('maxMiles', '\'0\'')->press('submit')->assertSee('The max miles must be an integer.')
                ->type('maxMiles', 0)->press('submit')->assertSee('The max miles must be between 1 and 200.')
                ->type('maxMiles', '201')->press('submit')->assertSee('The max miles must be between 1 and 200.')
                ->type('maxMiles', '')->press('submit')->assertSee('The max miles field is required.');

        });
    }

    public function test_StoreUserSelection_RejectsInvalidZipInput()
    {
        $this->browse(function ($browser){
            $browser->visit('/user-selections')
                ->type('zip', '')->press('submit')->assertSee('The zip field is required.')
                ->type('zip', 9549)->press('submit')->assertSee('The zip format is invalid.')
                ->type('zip', 954921)->press('submit')->assertSee('The zip format is invalid')
                ->type('zip', 'somestring')->press('submit')->assertSee('The zip format is invalid');

        });
    }*/

}
