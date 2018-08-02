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
    protected $validDestZipCodes = [95501, 96001, 91324];
    protected $validHomeZip = 95401;

    public function setUp(){
        parent::setUp();
        $this->service = new ExternalZipApiService();
    }

    public function test_getMilesBetweenZipCodes_returns_array_with_distance_key_values()
    {
        $distanceArray = $this->service->getMilesBetweenZipCodes($this->validDestZipCodes,$this->validHomeZip);
        $this->assertEquals(204, $distanceArray['96001']);
        $this->assertEquals(419, $distanceArray['91324']);
        $this->assertEquals(219, $distanceArray['95501']);
    }

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

    public function test_extractDistanceFromApiArray_returns_array_of_integers_representing_miles()
    {
        $data = $this->mock_google_api_distance_array();
        $arrayOfDistanceValues = $this->service->extractDistanceFromApiArray($data);
        $this->assertEquals([10,424], $arrayOfDistanceValues);
    }

    public function mock_google_api_distance_array()
    {
        $googleApiArray = [
            'rows' => [
                0 => [
                   'elements' => [
                       0 =>[
                           'distance' => [
                                    'text' => "10.0 mi"
                           ]
                       ],
                       1 => [
                           'distance' => [
                               'text' => "424 mi"
                           ]
                       ]
                   ]
                ]
            ]
        ];
        return $googleApiArray;
    }
}
