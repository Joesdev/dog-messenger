<?php

namespace App\Console\Commands;

use App\Services\DogDataService;
use App\Services\ExternalPetApiService;
use Illuminate\Console\Command;

class ResetUserRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Notify:Reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets All Subscribed Users to Allow Notifications and Dog Checking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $externalApiService = new ExternalPetApiService();
        $dogDataService = new DogDataService($externalApiService);
        $dogDataService->resetUsersToRankOne();
    }
}
