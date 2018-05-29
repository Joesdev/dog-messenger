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
    protected $validZipCodes = [['zip' => '91324'],['zip' => '98260'],['zip' => '88901']];
    protected $validFocusZipCode = '95492';

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
}
