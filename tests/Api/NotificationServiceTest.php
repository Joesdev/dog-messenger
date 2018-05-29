<?php

namespace Tests\Feature;

use App\Found_Dog;
use App\Services\NotificationService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new NotificationService();
        $this->seed('breedsTableSeeder');
        $this->seed('AllTableDataSeeder');
    }

    /*public function test_sendNotification_returns_found_dogs_rows_and_sends_notification(){
        $validEmail = 'joesilvpb4@gmail.com';
        $initialCountOfRows = Found_Dog::all()->count();
        $this->service->sendNotification($validEmail);
        $this->assertNotEquals($initialCountOfRows, Found_Dog::all()->count());
    }

    public function test_notifyNextBatchOfEmails_adds_dogs_to_found_dogs_table_and_resets_ranks_to_zero()
    {
        $countEligableUsers = User::where('rank',1)->get()->count();
        $batchOfEmailCount = 2;
        $this->service->notifyNextBatchOfEmails($batchOfEmailCount);
        $usersWithRankOne = User::where('rank',1)->get()->count();
        $this->assertEquals($countEligableUsers - $batchOfEmailCount, $usersWithRankOne);
    }*/
}
