<?php

namespace App\Console\Commands;

use App\Found_Dog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredFoundDogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:dogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes rows in found_dogs table which have exceeded the time limit';

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
        Found_Dog::where('created_at', '<=',Carbon::now()->subDays(14))->each(function($item){
           $item->delete();
        });
    }
}
