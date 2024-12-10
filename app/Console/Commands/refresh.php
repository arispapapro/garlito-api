<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Refresh Database Migrations
        Artisan::call('migrate:fresh');

        // Seed Database With Default Settings & Data
        Artisan::call('db:seed');

        // Optimize Application
        Artisan::call('optimize:clear');
    }
}
