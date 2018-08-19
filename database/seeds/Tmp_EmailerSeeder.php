<?php

use Illuminate\Database\Seeder;

class Tmp_EmailerSeeder extends Seeder
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
                'new_breed_id'  => '42338118',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'joesilvpb4@gmail.com',
                'new_breed_id'  => '42338238',
                'miles'         => 75
            ]);


            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilva@gmail.com',
                'new_breed_id'  => '42337990',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilva@gmail.com',
                'new_breed_id'  => '42337991',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilva@gmail.com',
                'new_breed_id'  => '42337992',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilva@gmail.com',
                'new_breed_id'  => '42337997',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'drycreeksilva@gmail.com',
                'new_breed_id'  => '42337999',
                'miles'         => 75
            ]);


            DB::table('found_dogs')->insert([
                'email'         => 'joey4favre@gmail.com',
                'new_breed_id'  => '42338001',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'joey4favre@gmail.com',
                'new_breed_id'  => '42338002',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'joey4favre@gmail.com',
                'new_breed_id'  => '42338003',
                'miles'         => 75
            ]);


            DB::table('found_dogs')->insert([
                'email'         => 'joseph.silva.275@my.csun.edu',
                'new_breed_id'  => '42338007',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'joseph.silva.275@my.csun.edu',
                'new_breed_id'  => '42338005',
                'miles'         => 75
            ]);
            DB::table('found_dogs')->insert([
                'email'         => 'joseph.silva.275@my.csun.edu',
                'new_breed_id'  => '42338006',
                'miles'         => 75
            ]);

    }
}
