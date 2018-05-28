<?php

namespace Tests\Feature;

use App\Found_Dog;
use App\Services\NotificationService;
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
        $this->seed('AllTableDataSeeder');
    }

    /*public function test_notifyNextBatchOfEmails_adds_dogs_to_found_dogs_table_and_resets_ranks_to_zero()
    {

    }*/

    public function test_sendNotification_returns_found_dogs_rows_and_sends_notification(){
        $validEmail = 'joesilvpb4@gmail.com';
        //Give I have a valid email address that is located in Users table
        $this->service->sendNotification($validEmail);
        //That email should have more dogs in the found dogs table and be notified by ema
    }
}
