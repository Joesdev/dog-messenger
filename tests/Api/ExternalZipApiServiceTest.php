<?php

namespace Tests\Feature;

use App\Services\ExternalZipApiService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExternalZipApiServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    public function setUp(){
        parent::setUp();
        $this->service = new ExternalZipApiService();
    }

    /*//API CALLS (3)
    public function test_getMilesBetweenZipCodes_returns_array_with_distance_key_values()
    {
        $distanceArray = $this->service->getMilesBetweenZipCodes($this->validZipCodes,$this->validFocusZipCode);
        $this->assertEquals(445.764,$distanceArray['88901']);
        $this->assertEquals(379.775,$distanceArray['91324']);
        $this->assertEquals(657.215,$distanceArray['98260']);
    }*/

    public function test_concatStringOfZipCodes_returns_a_string_of_zip_codes_with_or_operator_as_spacer()
    {
        $arrayOfZipCodes = [95492, 91324, 95501];
        $stringOfZipCodes = $this->service->concatStringOfZipCodes($arrayOfZipCodes);
        $this->assertEquals('95492|91324|95501', $stringOfZipCodes);
        $singleStringOfZipCode = $this->service->concatStringOfZipCodes([95492]);
        $this->assertEquals('95492', $singleStringOfZipCode);
    }

    public function test_queryGoogleDistanceApi_returns_status_of_ok_and_distance_values()
    {
        $homeZipCode = 91324;
        $destinationZipCodes = '95492|95401|95501';
        $data = $this->service->queryGoogleDistanceApi($homeZipCode, $destinationZipCodes);
        $status = $data['status'];
        $this->assertEquals('OK', $status);
    }

}
