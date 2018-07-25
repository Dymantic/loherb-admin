<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class MakeDefaultUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user to log in as [email: joe@example.com password: password]';

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
        User::create([
            'name' => 'Joe Soap',
            'email' => 'joe@example.com',
            'password' => bcrypt('password')
        ]);
    }
}
