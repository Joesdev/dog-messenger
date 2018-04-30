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
        factory(App\Selection::class, 3)->create()->each(function($selection){
            $selection->users()->save(factory(App\User::class)->make([
                'selection_id' => $selection->id
            ]));
        });
    }
}
