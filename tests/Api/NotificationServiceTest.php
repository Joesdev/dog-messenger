<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationServiceTest extends TestCase
{

    public function test_notifyNextBatchOfEmails_adds_dogs_to_found_dogs_table_and_resets_ranks_to_zero()
    {

    }

    public function test_sendNotification(){
        //Give I have a valid email address that is located in Users table
        //When I call the function
        //That email should have more dogs in the found dogs table and be notified by email
    }
}
