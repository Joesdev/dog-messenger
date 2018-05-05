<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(usersTableSeeder::class);
        $this->call(breedsTableSeeder::class);
        /*$this->call(found_dogsTableSeeder::class);*/
    }
}
