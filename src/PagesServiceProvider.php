<?php

namespace Sirgrimorum\Pages;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;

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
            $config = \Sirgrimorum\CrudGenerator\CrudGenerator::getConfig($path);
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
            $config = \Sirgrimorum\CrudGenerator\CrudGenerator::getConfig($path);
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