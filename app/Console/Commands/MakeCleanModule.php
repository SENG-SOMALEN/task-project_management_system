<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeCleanModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:clean-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a clean module structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->info("Creating module {$name}...");
    }
}
