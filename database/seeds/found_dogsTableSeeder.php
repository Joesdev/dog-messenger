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
               'email'          => 'joesilvpb4@gmail.com',
                'new_breed_id'  => '41240156',
                'miles'         => 81
            ]);

            DB::table('found_dogs')->insert([
                'email'         => 'joesilvpb4@gmail.com',
                'new_breed_id'  =>  '41223546',
                'miles'         => 135
            ]);
    }
}
