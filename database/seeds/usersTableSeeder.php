<?php

use Illuminate\Database\Seeder;

class usersTableSeeder extends Seeder
{
    // This seeder will create a related User & Selection Tables
    public function run()
    {
        factory(\App\User::class, 5)->create();
    }
}
