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

    public function setUp(){
        parent::setUp();
        $this->service = new ExternalPetApiService();
        //API CALL
        $this->validData = $this->getValidData();
        //API CALL
        $this->invalidData = $this->getInvalidData();
    }

    public function test_getExternalDataForBreed_ReturnsData(){

    }

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
        $this->expectException(IndexException::class);
        $this->service->validateDogData($this->invalidData);

    }

    public function test_getCount_ReturnsValidInt(){
        $expected = 75;
        $actual = $this->service->getCount();
        $this->assertSame($expected, $actual);
    }



    //-----------------------Helper Functions-------------------------------------------------------
    public function getValidData(){
        return $this->service->getRawDogApiData($this->validZip,$this->validBreed);
    }

    public function getInvalidData(){
        return $this->service->getRawDogApiData($this->invalidZip, $this->invalidBreed);
    }
}
