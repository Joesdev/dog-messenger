<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\NotificationService;
class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Notify:Users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabs Users Who Have Not Checked Their Breed Status Today, Notifies Them';

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
        $notificationService = new NotificationService();
        $notificationService->notifyNextTwoEmails();
       /* $request = Request::create($this->argument('uri'), 'GET');
        $this->info(app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request));*/
    }
}
