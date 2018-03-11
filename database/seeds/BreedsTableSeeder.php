<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $readFile = Storage::disk('local')->get('/data/breeds.json');
        $breedsArray = json_decode($readFile, true);
        foreach($breedsArray as $breed){
            DB::table('breeds')->insert([
                'breed' => $breed
            ]);
        }
    }
}
