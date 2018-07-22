<?php

use Illuminate\Database\Seeder;

class found_dogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('found_dogs')->insert([
                'email'         => 'joesilvpb4@gmail.com',
                'new_breed_id'  => '40756039',
                'miles'         => 100
            ]);

            DB::table('found_dogs')->insert([
                'email'         => 'joesilvpb4@gmail.com',
                'new_breed_id'  => '19850765',
                'miles'         => 75
            ]);




    }
}
