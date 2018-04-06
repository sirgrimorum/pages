<?php

namespace Sirgrimorum\Pages;

use Illuminate\Http\Request;
use App\User;
use Sirgrimorum\Pages\Models\Pagina;
use Illuminate\Support\Facades\Session;
use Sirgrimorum\CrudGenerator\CrudGenerator;
use App\Http\Controllers\Controller;

class PaginaController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return  void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request) {
        //$this->authorize('index', Pagina::class);
        $pagina = Pages::getFirstAllowedPage();
        if ($pagina) {
            return redirect(route(config('sirgrimorum.pages.group_name', 'paginas.') . 'show', $pagina->get("link")));
        }
        $mensajes = trans("crudgenerator::pagina.messages");
        $paginaName = "NA";
        Session::flash(config("sirgrimorum.crudgenerator.error_messages_key"), str_replace([":modelName", ":modelId"], [$paginaName, 0], $mensajes["no_access"]));
        return view('sirgrimpages::error');
    }

    /**
     * Display the specified resource.
     *
     * @param    string  $pagina
     * @return  \Illuminate\Http\Response
     */
    public function show(string $paginaName, Request $request) {
        $pagina = Pagina::getByLink($paginaName);
        if ($pagina) {
            //$this->authorize('show', $pagina);
            if (Pages::hasAccessToPagina($pagina)) {
                return view('sirgrimpages::show', [
                    'user' => $request->user(),
                    'pagina' => $pagina,
                ]);
            } else {
                $mensajes = trans("crudgenerator::pagina.messages");
                Session::flash(config("sirgrimorum.crudgenerator.error_messages_key"), str_replace([":modelName", ":modelId"], [$paginaName, 0], $mensajes["no_access"]));
            }
        } else {
            $mensajes = trans("crudgenerator::pagina.messages");
            Session::flash(config("sirgrimorum.crudgenerator.error_messages_key"), str_replace([":modelName", ":modelId"], [$paginaName, 0], $mensajes["not_found"]));
        }
        return view('sirgrimpages::error');
    }

}
