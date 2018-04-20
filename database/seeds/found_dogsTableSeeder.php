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
                'new_breed_id'  => '41426621',
                'miles'         => 114
            ]);

            DB::table('found_dogs')->insert([
                'email'         => 'joesilvpb4@gmail.com',
                'new_breed_id'  => '41440517',
                'miles'         => 118
            ]);

            DB::table('found_dogs')->insert([
                'email'         => 'joesilvpb4@gmail.com',
                'new_breed_id'  => '41439943',
                'miles'         => 398
            ]);

            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilv@gmail.com',
                'new_breed_id'  => '41424643',
                'miles'         => 21
            ]);

            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilv@gmail.com',
                'new_breed_id'  => '41432730',
                'miles'         => 30
            ]);

            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilv@gmail.com',
                'new_breed_id'  => '41432731',
                'miles'         => 30
            ]);



    }
}
