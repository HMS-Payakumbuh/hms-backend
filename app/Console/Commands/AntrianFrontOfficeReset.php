<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AntrianFrontOffice;

class AntrianFrontOfficeReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:antrian_front_office';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Antrian Front Office Every Day';

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
        AntrianFrontOffice::truncate();
        $this->info('Cleaning was executed successfully!');
    }
}
