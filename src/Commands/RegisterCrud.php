<?php

namespace Sirgrimorum\Pages\Commands;

use Illuminate\Console\Command;

class RegisterCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:registercrud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register de configurations files in sirgrimorum/crudgenerator';

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
        $bar = $this->output->createProgressBar(4);

        $this->line("Registering Pagina Config in crudgenerator configuration file");
        $path = 'sirgrimorum.models.pagina';
        $config = \Sirgrimorum\CrudGenerator\CrudGenerator::getConfig('pagina', false, $path);
        $bar->advance();
        $this->info("Config Loaded");
        if (\Sirgrimorum\CrudGenerator\CrudGenerator::registerConfig($config, $path)) {
            $this->info("Config registered!");
            $bar->advance();
        } else {
            $this->error("Something went wrong and config could not be registered");
            $bar->advance();
        }
        $this->line("Registering Section Config in crudgenerator configuration file");
        $path = 'sirgrimorum.models.section';
        $config = \Sirgrimorum\CrudGenerator\CrudGenerator::getConfig('section', false, $path);
        $bar->advance();
        $this->info("Config Loaded");
        if (\Sirgrimorum\CrudGenerator\CrudGenerator::registerConfig($config, $path)) {
            $this->info("Config registered!");
            $bar->finish();
        } else {
            $this->error("Something went wrong and config could not be registered");
            $bar->finish();
        }
        return 0;
    }
}
