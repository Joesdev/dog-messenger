<?php

namespace Tests\Unit;

use App\Exceptions\IndexException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ExternalPetApiService;

class ExternalPetApiServiceTest extends TestCase
{
    private $service;
    private $validData, $invalidData;
    private $validZip = 91324;
    private $invalidZip = 11111;
    private $validBreed = 'Akita';
    private $invalidBreed = 'Huzzky';

    private $indexException;

    public function setUp(){
        parent::setUp();
        $this->service = new ExternalPetApiService();
        //API CALL
        /**//*$this->validData = $this->getValidData();*/
        //API CALL
        /*$this->invalidData = $this->getInvalidData();*/
        /*$this->indexException = IndexException::class;*/
    }

    /*//API CALL
    public function test_getExternalDataForBreed_ReturnsDataWhenSuccessful(){
        $response = $this->service->getExternalDataForBreed($this->validZip,$this->validBreed);
        $this->assertEquals($this->service->getCount(),count($response));

    }
    //API CALL
    public function test_getExternalDataForBreed_ReturnsExceptionWhenApiReturnsNoData(){
        $this->expectException($this->indexException);
        $this->service->getExternalDataForBreed($this->invalidZip,$this->invalidBreed);
    }
    //API CALL
    public function test_getRawDogApiData_ReturnsSucess()
    {
        $response = $this->service->getRawDogApiData($this->validZip, $this->validBreed);
        $status_code = $response['petfinder']['header']['status']['code']['$t'];
        $arrayOfPets = $response['petfinder']['pets']['pet'];
        $this->assertEquals(100,$status_code);
        $this->assertEquals($this->service->getCount(), count($arrayOfPets));
    }

    public function test_validateDogData_ReturnsData()
    {
        $this->assertEquals($this->service->getCount(), count($this->service->validateDogData($this->validData)));
    }

    public function test_validateDogData_RedirectsIfNull(){
        $this->expectException($this->indexException);
        $this->service->validateDogData($this->invalidData);

    }

    public function test_getCount_ReturnsValidInt(){
        $expected = 75;
        $actual = $this->service->getCount();
        $this->assertSame($expected, $actual);
    }*/
    //API CALL
    public function test_validateMediaKey_returns_a_url_or_a_hashtag(){
        $picWidth = '500';
        $dogData = $this->mock_pet_api_data_for_single_dog();
        $returnedString = $this->service->validateMediaKey($picWidth,$dogData);
        //Check if string is a url, if so verify it has width of 500, else verify string is '#'
        $urlCheck = filter_var($returnedString,FILTER_VALIDATE_URL);
        if($urlCheck){
            $this->assertContains($picWidth,$returnedString);
        }else{
            $this->assertEquals('#',$returnedString);
        };

    }

    public function test_appendSexString_appends_male_or_female_string()
    {
        $output = $this->service->appendSexString('f');
        $this->assertEquals('Female',$output);
        $output = $this->service->appendSexString('m');
        $this->assertEquals('Male',$output);
        $output = $this->service->appendSexString('Not Available');
        $this->assertEquals('Not Available',$output);
    }



    //-----------------------Helper Functions-------------------------------------------------------
    /*public function getValidData(){
        return $this->service->getRawDogApiData($this->validZip,$this->validBreed);
    }

    public function getInvalidData(){
        return $this->service->getRawDogApiData($this->invalidZip, $this->invalidBreed);
    }*/

    public function mock_pet_api_data_for_single_dog(){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET',
            'api.petfinder.com/pet.getRandom?key='.env('API_KEY').'&animal=dog&format=json&output=basic');
        $response = json_decode($response->getBody()->getContents(),true);
        $data = $response['petfinder']['pet'];
        return $data;
    }
}
