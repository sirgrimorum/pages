<?php

namespace Sirgrimorum\Pages\Commands;

use Illuminate\Console\Command;

class RegisterMiddleware extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:registermiddleware';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register the Pages middleware in app/Http/Kernel.php';

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
        $path = \Illuminate\Support\Str::finish(str_replace(["/"], ["\\"], app_path('Http/Kernel.php')), '.php');
        $middlewareClass = "\\Sirgrimorum\\Pages\\Middleware\\PagesRedirectMiddleware";
        if (file_exists($path)) {
            $contents = file($path);
            $inicio = -1;
            $webEncontrado = -1;
            $fin = -1;
            $encontrado = -1;
            foreach ($contents as $index => $line) {
                if (strpos($line, '$middlewareGroups = [') !== false) {
                    $inicio = $index;
                }
                if (strpos($line, "'web'") !== false && $inicio >= 0 && $fin == -1) {
                    $webEncontrado = $index;
                }
                if (strpos($line, $middlewareClass) !== false && $inicio >= 0 && $webEncontrado >= 0 && $fin == -1) {
                    $encontrado = $index;
                }
                if (strpos($line, "],") !== false && $inicio >= 0  && $webEncontrado >= 0 && $fin == -1) {
                    $fin = $index;
                }
            }
            $newTexto = chr(9) . $middlewareClass . "::class, " . chr(13) . chr(10);
            if ($encontrado >= 0) {
                $contents[$encontrado] = $newTexto;
            } elseif ($webEncontrado >= 0 && $fin >= 0) {
                $newContent = array_slice($contents, 0, $fin);
                $newContent[] = $newTexto;
                foreach (array_slice($contents, $fin) as $linea) {
                    $newContent[] = $linea;
                }
                $contents = $newContent;
            }
            $contents = file_put_contents($path, $contents);
        } else {
            $contents = false;
        }
        if ($contents) {
            $this->info("Pages middleware registered");
        } else {
            $this->error("Something went wrong registering Pages middleware, please register it in app/Http/Kernel.php under web group");
        }
    }
}
