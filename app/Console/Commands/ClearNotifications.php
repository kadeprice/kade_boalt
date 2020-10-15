<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;

class ClearNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:clearall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear All notifications for all users.';

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
     * call Notification clear all method
     * @return int
     */
    public function handle(Notification $notification)
    {
        $notification->clearAll();
        echo"Notifications Cleared \n";
        return 0;
    }
}
