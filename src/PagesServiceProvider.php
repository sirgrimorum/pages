<?php

namespace Sirgrimorum\Pages;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Artisan;

class PagesServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->publishes([
            __DIR__ . '/Config/pages.php' => config_path('sirgrimorum/pages.php'),
                ], 'config');
        $this->publishes([
            __DIR__ . '/ModelConfig' => config_path('sirgrimorum/models'),
                ], 'config');
        $this->loadViewsFrom(__DIR__ . '/Views', 'sirgrimpages');
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/sirgrimorum/pages'),
                ], 'views');
        $this->loadTranslationsFrom(__DIR__ . 'Lang', 'pages');
        $this->publishes([
            __DIR__ . '/Lang' => resource_path('lang/vendor/pages'),
                ], 'lang');
        $this->publishes([
            __DIR__ . '/ModelLang' => resource_path('lang/vendor/crudgenerator'),
                ], 'lang');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        Blade::directive('load_page', function($expression) {
            $auxExpression = explode(',', str_replace(['(', ')', ' ', '"', "'"], '', $expression));
            if (count($auxExpression) > 1) {
                $name = $auxExpression[0];
                $config = $auxExpression[1];
            } elseif (count($auxExpression) > 0) {
                $name = $auxExpression[0];
                $config = "";
            } else {
                $name = "";
                $config = "";
            }
            return Pages::buildPage($name, $config);
        });
        Blade::directive('load_section', function($expression) {
            $auxExpression = explode(',', str_replace(['(', ')', ' ', '"', "'"], '', $expression));
            if (count($auxExpression) > 1) {
                $name = $auxExpression[0];
                $config = $auxExpression[1];
            } elseif (count($auxExpression) > 0) {
                $name = $auxExpression[0];
                $config = "";
            } else {
                $name = "";
                $config = "";
            }
            return Pages::buildSection($name, $config);
        });

        Artisan::command('pages:registercrud', function () {
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
        })->describe('Register de configurations files in sirgrimorum/crudgenerator');
        
        Artisan::command('pages:createseed', function () {
            $bar = $this->output->createProgressBar(2);
            $confirm = $this->choice("Do you wisth to clean the DatabaseSeeder.php list?", ['yes', 'no'], 0);
            $bar->advance();
            $nombre = date("Y_m_d_His");
            if ($confirm == 'yes') {
                $this->line("Creating seed archive of articles table and celaning DatabaseSeeder");
                Artisan::call("iseed articles,paginas,sections --classnameprefix={$nombre} --chunksize=100 --clean");
            } else {
                $this->line("Creating seed archive of articles table and adding to DatabaseSeeder list");
                Artisan::call("iseed articles,paginas,sections --classnameprefix={$nombre} --chunksize=100");
            }
            $this->info("Seed files created with the names {$nombre}ArticlesSeeder.php, {$nombre}PaginasSeeder.php, {$nombre}SectionsSeeder.php");
            $bar->advance();
            $bar->finish();
        })->describe('Create seeder files with the current tables Articles, Paginas and Sections');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(
                __DIR__ . '/Config/pages.php', 'sirgrimorum.pages'
        );
        $loader = AliasLoader::getInstance();
        $loader->alias(
                'Pages', Pages::class
        );
    }

}
