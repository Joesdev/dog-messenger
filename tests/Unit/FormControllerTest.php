<?php

namespace Tests\Unit;

use App\Selection;
use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use App\Services\ExternalZipApiService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Http\Controllers\FormController;

class FormControllerTest extends TestCase
{
    use RefreshDatabase;
    //Data
    private $url = "/";
    private $numRows = 4;
    private $form;
    private $validZip = '95402';
    private $validMiles = 50;
    //Services
    private $petApiService;
    private $zipApiService;
    private $dogService;

    public function setUp(){
        parent::setUp();
        //A user will automatically create a related selection row
        factory(User::class,$this->numRows)->create();

        $this->seed('breedsTableSeeder');
        $this->petApiService = new ExternalPetApiService();
        $this->zipApiService = new ExternalZipApiService();
        $this->dogService = new DogDataService($this->petApiService,$this->zipApiService);
        $this->form = new FormController($this->petApiService,$this->dogService);
    }

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

    public function test_StoreUsersSelection_StoresUser()
    {
        $this->sendForm();
        $this->assertCount(5,User::all());
    }

    public function test_storeSelection_stores_single_row_in_database(){
        $this->post('/selection/'.$this->validZip.'/'.$this->validMiles);
        $this->assertCount($this->numRows + 1,Selection::all());
        $this->assertDatabaseHas('selections', [
            'zip'      => $this->validZip,
            'max_miles' => $this->validMiles,
            'match'    => 0
        ]);
    }

    // --------------------------------- Helper Functions -------------------------------------------
    protected function sendForm($attributes = [])
    {
        $this->withExceptionHandling();
        return $this->post($this->url,$this->validFields($attributes));
    }

    protected function validFields($overrides = [])
    {
        return array_merge([
            'email' => 'johndoe@gmail.com',
            'maxMiles' => 75,
            'zip' => 95492,
        ], $overrides);
    }
}
