<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;

class All extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:all';

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
        $this->call('migrate:refresh');

        $this->call('app:create-user', [
            'email' => 'alex@functiontales.com',
            'password' => '12121212',
            'is_admin' => 1,
            'name' => 'Admin',
        ]);

        $this->call('dev:create-demo-data');
    }
}
