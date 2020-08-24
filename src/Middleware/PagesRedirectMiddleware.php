<?php

namespace Sirgrimorum\Pages\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Sirgrimorum\Pages\Models\Pagina;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Sirgrimorum\Pages\Pages;

class PagesRedirectMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->path();
        $prefijoPages = config('sirgrimorum.pages.group_prefix', '');
        if ($prefijoPages != "") {
            $prefijoPages = Str::finish($prefijoPages, '/');
        }
        if ($request->is($prefijoPages . "*")) {
            $paginaName = Str::afterLast($uri, "/");
            $pagina = Pagina::getByLink($paginaName);
            if (!$pagina) {
                $routes = Route::getRoutes();
                $pagesRequest = $request->create($uri);
                try {
                    $routeEncontrada = $routes->match($pagesRequest);
                } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
                    $routeEncontrada = false;
                }
                if ($routeEncontrada !== false && $routeEncontrada->getName() == config('sirgrimorum.pages.group_name', 'paginas.') . "show"){
                    foreach ($routes as $route) {
                        if ($route->getName() != config('sirgrimorum.pages.group_name', 'paginas.') . "show") {
                            if ($route->matches($request)) {
                                //return response("<p>Lo encontramos es con for</p><pre>" . print_r($route->action, true) . "</pre>");
                                return response($route->bind($request)->run());
                            }
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
