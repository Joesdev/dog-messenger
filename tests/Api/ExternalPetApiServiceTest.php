<?php

namespace Tests\Unit;

use App\Exceptions\IndexException;
use App\Exceptions\InvalidLocationException;
use App\Exceptions\InvalidPetIdException;
use App\Found_Dog;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ExternalPetApiService;

class ExternalPetApiServiceTest extends TestCase
{
    use RefreshDatabase;

    private $service;
    private $validData, $invalidData;
    private $validZip = 91324;
    private $invalidZip = 11111;

    private $indexException;
    private $invalidPetIdException;
    private $invalidLocationException;

    public function setUp(){
        parent::setUp();
        $this->service = new ExternalPetApiService();
        //API CALL
        $this->validData = $this->getValidData();
        //API CALL
        $this->invalidData = $this->getInvalidData();
        $this->indexException = IndexException::class;
        $this->invalidLocationException = InvalidLocationException::class;
        $this->invalidPetIdException = InvalidPetIdException::class;
    }

    //API CALL
    public function test_getExternalDataForDogs_ReturnsDataWhenSuccessful(){
        $response = $this->service->getExternalDataForDogs($this->validZip);
        $this->assertEquals($this->service->getCount(),count($response));
    }
    //API CALL
    public function test_getExternalDataForDogs_ReturnsExceptionWhenApiReturnsNoData(){
        $this->expectException($this->invalidLocationException);
        $this->service->getExternalDataForDogs($this->invalidZip);
    }
    //API CALL
    public function test_getRawDogApiData_ReturnsSucess()
    {
        $response = $this->service->getRawDogApiData($this->validZip);
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
        $this->expectException($this->invalidLocationException);
        $this->service->validateDogData($this->invalidData);

    }

    public function test_getCount_ReturnsValidInt(){
        $expected = 75;
        $actual = $this->service->getCount();
        $this->assertSame($expected, $actual);
    }

    public function test_getExternalDataForSingleDog_throws_exception_for_invalid_pet_id(){
        $invalidPetId = 50;
        $this->assertEquals(false, $this->service->getExternalDataForSingleDog($invalidPetId));
    }

    public function test_getExternalDataForSingleDog_returns_valid_data(){
        $validPetId = 41619837;
        $dogData = $this->service->getExternalDataForSingleDog($validPetId);
        $this->assertAllKeysExist($dogData);
    }

    public function test_getStatusCode_throws_exception_when_status_code_key_doesnt_exist()
    {
        $arrayWithNoStatusCode = [
            'petfinder' => [
                    'nokey' => 'somevalue'
            ]
        ];
        $this->expectException($this->indexException);
        $this->service->getStatusCode($arrayWithNoStatusCode);
    }

    public function test_getStatusCode_returns_status_code_when_key_value_exists()
    {
        $arrayWithStatusCode['petfinder']['header']['status']['code']['$t'] = '200';
        $statuCode = $this->service->getStatusCode($arrayWithStatusCode);
        $this->assertEquals('200',$statuCode);
    }


    //API CALL
    public function test_getSlimDogData_returns_data_without_errors(){
        $dogData = $this->mock_pet_api_data_for_single_dog();
        $output = $this->service->getSlimDogData($dogData);
        $this->assertAllKeysExist($output);
    }

    public function test_validateKey__returns_Not_Available_for_empty_keys(){
        //When Key has a value
        $data = $this->mock_general_key('description', 'He likes to bark.');
        $output = $this->service->validateKey('description',$data);
        $this->assertEquals('He likes to bark.', $output[0]);

        //When Key has empty value
        $data = $this->mock_general_key('description', 'nothing');
        $data['description']= [];
        $output = $this->service->validateKey('description',$data);
        $this->assertEquals('Not Available', $output);
    }

    public function test_validateContactKey_returns_Not_Available_for_empty_keys(){
        //When Key has a value
        $data = $this->mock_contact_key('phone', '123-456-789');
        $output = $this->service->validateContactKey('phone',$data);
        $this->assertEquals('123-456-789', $output[0]);

        //When Key has empty value
        $data = $this->mock_contact_key('phone', 'nothing');
        $data['contact']['phone'] = [];
        $output = $this->service->validateContactKey('phone',$data);
        $this->assertEquals('Not Available', $output);
    }

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

    public function test_appendFoundDogCollectionDataToApiData_returns_api_data_with_distance_key_values()
    {
        $this->seed('found_dogsTableSeeder');
        $found_dogs = Found_Dog::all();
        $dog_data = $this->service->appendFoundDogCollectionDataToApiData($found_dogs);
        $this->assertAllKeysExist($dog_data[0]);
        $this->assertArrayHasKey('distance', $dog_data[0]);
    }

    //-----------------------Helper Functions-------------------------------------------------------

    public function assertAllKeysExist($dogData)
    {
        $this->assertArrayHasKey('name',$dogData);
        $this->assertArrayHasKey('sex',$dogData);
        $this->assertArrayHasKey('mix',$dogData);
        $this->assertArrayHasKey('description',$dogData);
        $this->assertArrayHasKey('phone',$dogData);
        $this->assertArrayHasKey('email',$dogData);
        $this->assertArrayHasKey('address',$dogData);
        $this->assertArrayHasKey('city',$dogData);
        $this->assertArrayHasKey('state',$dogData);
        $this->assertArrayHasKey('zip',$dogData);
        $this->assertArrayHasKey('media',$dogData);
    }
    public function getValidData(){
        return $this->service->getRawDogApiData($this->validZip);
    }

    public function getInvalidData(){
        return $this->service->getRawDogApiData($this->invalidZip);
    }

    public function mock_pet_api_data_for_single_dog(){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET',
            'api.petfinder.com/pet.getRandom?key='.env('API_KEY').'&animal=dog&format=json&output=basic');
        $response = json_decode($response->getBody()->getContents(),true);
        $data = $response['petfinder']['pet'];
        return $data;
    }

    public function mock_contact_key($key, $value){
        return [
            'contact' => [
                $key => [
                    '$t' =>[
                        $value
                    ]
                ]
            ]
        ];
    }

    public function mock_general_key($key, $value){
        return [
                $key => [
                    '$t' =>[
                        $value
                    ]
                ]
        ];
    }

}
