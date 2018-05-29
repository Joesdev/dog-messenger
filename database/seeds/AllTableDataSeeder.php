<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\User;
use App\Selection;
use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use App\Services\ExternalZipApiService;

class AllTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $externalPetApiService = new ExternalPetApiService();
        $externalZipApiService = new ExternalZipApiService();
        $dogDataService = new DogDataService($externalPetApiService, $externalZipApiService);
        $emails = [
            ['joesilvpb4@gmail.com'],
            ['drycreeksilv@gmail.com'],
            ['drycreeksilva@gmail.com'],
            ['joey4favre@gmail.com'],
            ['joseph.silva.275@my.csun.edu']
        ];
        $zips = ['95492', '91324', '97035', '93650', '85001'];
        $maxMiles = [125, 125, 50, 75, 100];
        $index = 0;
        //Create Five Users with Related Selections
        foreach($emails as $email) {
            DB::table('users')->insert([
                'rank' => 1,
                'name' => 'NA',
                'email' => $email[0],
                'selection_id' => $index + 1
            ]);

            DB::table('selections')->insert([
                'id' => $index + 1,
                'breed_id' => 5 + $index,
                'zip' => $zips[$index],
                'highest_breed_id' => 41000000,
                'max_miles' => $maxMiles[$index],
                'match' => 0
            ]);
            //Update the highest breed id column
            $dogDataService->getUpdatedBreedArray($email[0]);
            $highestId = Selection::where('id', $index + 1)->get()->pluck('highest_breed_id');
            Selection::where('id', $index + 1)->update([
                'highest_breed_id' => $highestId[0] - 10000
            ]);
            $index++;
        }

    }
}
