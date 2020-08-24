<?php

namespace Sirgrimorum\Pages\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:createseed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create seeder files with the current tables Articles, Paginas and Sections';

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
        $bar = $this->output->createProgressBar(2);
        $confirm = $this->choice("Do you wisth to clean the DatabaseSeeder.php list?", ['yes', 'no'], 0);
        $bar->advance();
        $nombre = date("YmdHis");
        if ($confirm == 'yes') {
            $this->line("Creating seed archive of articles table and celaning DatabaseSeeder");
            Artisan::call("iseed articles,paginas,sections --classnamesuffix={$nombre} --chunksize=100 --clean");
        } else {
            $this->line("Creating seed archive of articles table and adding to DatabaseSeeder list");
            Artisan::call("iseed articles,paginas,sections --classnamesuffix={$nombre} --chunksize=100");
        }
        $this->info("Seed files created with the names Articles{$nombre}Seeder.php, Paginas{$nombre}Seeder.php, Sections{$nombre}Seeder.php");
        $bar->advance();
        $bar->finish();
    }
}
