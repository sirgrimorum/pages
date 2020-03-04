<?php

namespace Sirgrimorum\Pages;

class Pages {

    function __construct() {
        
    }

    /**
     * Get the first allowed page or null
     * @return Sirgrimorum\Pages\Models\Pagina
     */
    public static function getFirstAllowedPage() {
        $PaginasModel = config('sirgrimorum.pages.default_paginas_model', 'Sirgrimorum\Pages\Models\Pagina');
        foreach ($PaginasModel::where('activo', '=', '1')->orderBy('order')->get() as $pagina) {
            if (Pages::hasAccessToPagina($pagina)) {
                return $pagina;
            }
        }
        return null;
    }

    /**
     * Return the html of a pagina
     * 
     * @param mix $name The pagina name, id or object. If "" it will use the first allowed page.
     * @param string|array $config Optional, the config path or array
     * @param array $sections Optional, the sections to load on the pagina
     * @return string
     */
    public static function buildPage($name, $config = "", $sections = "") {
        $html = "";
        if (!is_array($config)) {
            if ($config == "") {
                $config = 'sirgrimorum.pages';
            }
            $config = config($config);
        }
        $PaginasModel = \Illuminate\Support\Arr::get($config, 'default_paginas_model', 'Sirgrimorum\Pages\Models\Pagina');
        if (is_object($name)) {
            $pagina = $name;
        } elseif ($name == "") {
            $pagina = Pages::getFirstAllowedPage();
        } elseif (is_string($name)) {
            $pagina = $PaginasModel::where("name", "=", $name)->first();
        } else {
            $pagina = false;
        }
        if ($pagina) {
            if (Pages::hasAccessToPagina($pagina)) {
                $html = $pagina->get("template");
                /* load sections */
                if (stripos($html, "{%%sections%%}") === false) {
                    $html .="{%%sections%%}";
                }
                $html_sections = "";
                if ($sections == "") {
                    $sections = $pagina->sections()->where("activo", "=", "1")->orderBy("order")->get();
                }
                foreach ($sections as $section) {
                    if (Pages::hasAccessToSection($section)) {
                        $html_sections .=$section->get("titulo") . $section->get("texto");
                    }
                }
                $html = str_replace("{%%sections%%}", $html_sections, $html);
                $html = Pages::buildSpecialSections($html, $config, ['pagina' => $pagina]);
            } else {
                $mensajes = trans("crudgenerator::pagina.messages");
                $mensaje = str_replace([":modelName", ":modelId"], [$name, 0], $mensajes["no_access"]);
                $html = '<div class="container">' .
                        '    <div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                        '        <button type="button" class="close" data-dismiss="alert" aria-label="{{trans("crudgenerator::admin.layout.labels.close")}}"><span aria-hidden="true">&times;</span></button>' .
                        '        ' . $mensaje .
                        '    </div>' .
                        '</div>';
            }
        } else {
            $mensajes = trans("crudgenerator::pagina.messages");
            $mensaje = str_replace([":modelName", ":modelId"], [$name, 0], $mensajes["not_found"]);
            $html = '<div class="container">' .
                    '    <div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                    '        <button type="button" class="close" data-dismiss="alert" aria-label="{{trans("crudgenerator::admin.layout.labels.close")}}"><span aria-hidden="true">&times;</span></button>' .
                    '        ' . $mensaje .
                    '    </div>' .
                    '</div>';
        }
        return $html;
    }

    /**
     * Return the html of a section
     * @param mix $name The section name, id or object
     * @param string|array $config Optional, the config path or array
     * @return type
     */
    public static function buildSection($name, $config = "") {
        $html = "";
        if (!is_array($config)) {
            if ($config == "") {
                $config = 'sirgrimorum.pages';
            }
            $config = config($config);
        }
        $SectionsModel = \Illuminate\Support\Arr::get($config, 'default_sections_model', 'Sirgrimorum\Pages\Models\Section');
        if (is_object($name)) {
            $section = $name;
        } elseif (is_string($name)) {
            $section = $SectionsModel::where("name", "=", $name)->first();
        } else {
            $section = false;
        }
        if ($section) {
            if (Pages::hasAccessToSection($section)) {
                $html = $section->get("titulo") . $section->get("texto");
                $html = Pages::buildSpecialSections($html, $config, ['pagina' => $section->pagina]);
            }
        }
        return $html;
    }

    /**
     * Replace the special sections in the html
     * 
     * @param string $html Current html
     * @param string|array $config Optional, the config path or array
     * @param array $parameters Aditional parameters to be passed to the blades
     * @return string
     */
    private static function buildSpecialSections($html = "", $config = "", $parameters = []) {
        /* load special sections */
        if (!is_array($config)) {
            if ($config == "") {
                $config = 'sirgrimorum.pages';
            }
            $config = config($config);
        }
        if (is_array(\Illuminate\Support\Arr::get($config, 'special_sections', []))) {
            foreach (\Illuminate\Support\Arr::get($config, 'special_sections', []) as $nombre => $special) {
                if (stripos($html, "{%%$nombre%%}") !== false) {
                    $html_special = \Illuminate\Support\Arr::get($special, "pre_html", "");
                    if ($special['type'] == 'collection' || $special['type'] == 'model') {
                        if ($special['type'] == 'collection') {
                            if (is_array($special['collection'])) {
                                if (isset($special['collection']['class'])) {
                                    $query = \Illuminate\Support\Arr::get($special['collection'], "query", "1 = 1");
                                    if ($query == "") {
                                        $query = "1 = 1";
                                    }
                                    $orderBy = \Illuminate\Support\Arr::get($special['collection'], "orderBy", (new $special['collection']['class'])->getKeyName());
                                    $order = \Illuminate\Support\Arr::get($special['collection'], "order", "asc");
                                    if ($special['collection']['isModel'] && isset($special['collection']['attribute'])){
                                        $collection = $special['collection']['class']::whereRaw($query)->orderBy($orderBy, $order)->first()->{$special['collection']['attribute']};
                                    }elseif($special['collection']['isModel'] && isset($special['collection']['function'])){
                                        $collection = $special['collection']['class']::whereRaw($query)->orderBy($orderBy, $order)->first()->{$special['collection']['function']}();
                                    }else{
                                        $collection = $special['collection']['class']::whereRaw($query)->orderBy($orderBy, $order)->get();
                                    }
                                } else {
                                    $collection = $special['collection'];
                                }
                            } else {
                                $collection = $special['collection'];
                            }
                        } else {
                            $collection = $special['model']::all();
                        }
                        foreach ($collection as $model) {
                            $html_special .= View($special['blade'], array_merge($special['parameters'], $parameters, [
                                'user' => request()->user(),
                                'special_section' => $nombre,
                                $special['object_name'] => $model
                                    ]))->render();
                        }
                    } else {
                        $html_special = View($special['blade'], array_merge($special['parameters'], $parameters, [
                            'user' => request()->user(),
                            'special_section' => $nombre
                                ]))->render();
                    }
                    $html_special .= \Illuminate\Support\Arr::get($special, "post_html", "");
                    $html = str_replace("{%%$nombre%%}", $html_special, $html);
                }
            }
        }
        return $html;
    }

    /**
     * Get the configuration array for the Sirgirmorum/AutoMenu
     * 
     * @param int $offset The place in the original configuration where the links to the menu will be placed
     * @param string $lado Optional, the menu where the links will be placed
     * @param string|array $automenu Optional, the automenu configuration path or array
     * @return array
     */
    public static function getAutoMenuConfig($offset = 0, $lado = 'izquierdo', $automenu = "") {
        if (is_string($automenu)) {
            if ($automenu == "") {
                $automenu = 'automenu::automenu';
            }
            $automenu = trans($automenu);
        }
        if (!is_array($automenu)) {
            $automenu = trans('automenu::automenu');
        }
        if (!is_array($automenu)) {
            $automenu = [$lado => []];
        }
        $auxArray = [];
        $PaginasModel = config('sirgrimorum.pages.default_paginas_model', 'Sirgrimorum\Pages\Models\Pagina');
        foreach ($PaginasModel::where("activo", "=", "1")->where("order",">","0")->orderBy("order")->get() as $pagina) {
            if (Pages::hasAccessToPagina($pagina)) {
                $auxArray[$pagina->get("menu")] = route(config('sirgrimorum.pages.group_name', 'paginas.') . 'show', $pagina->get("link"));
            }
        }
        $automenu[$lado] = array_slice($automenu[$lado], 0, $offset, true) + $auxArray + array_slice($automenu[$lado], $offset, count($automenu[$lado]) - $offset, true);
        return $automenu;
    }

    /**
     * Whether the pagina is allowed to be seen right now or not
     * 
     * @param Sirgrimorum\Pages\Models\Pagina $pagina
     * @return boolean
     */
    public static function hasAccessToPagina($pagina) {
        return Pages::hasAccess("paginas", $pagina);
    }

    /**
     * Whether the section is allowed to be seen right now or not
     * 
     * @param Sirgrimorum\Pages\Models\Section $section
     * @return boolean
     */
    public static function hasAccessToSection($section) {
        return Pages::hasAccess("sections", $section);
    }

    /**
     * Whether a section or pagina is allowed to be seen right now or not
     * 
     * @param string $tipo 'paginas' or 'sections'
     * @param Object $objeto The pagina or section
     * @return boolean
     */
    private static function hasAccess($tipo, $objeto) {
        if ($objeto) {
            if ($tipo == "paginas" || $tipo == "sections") {
                foreach (config("sirgrimorum.pages.{$tipo}_policies") as $rule => $funcion) {
                    $cumple = false;
                    if (stripos($rule, '*') === 0) {
                        $rule = substr($rule, 1);
                        if (stripos($rule, '*') !== false) {
                            $rule = str_replace("*", "", $rule);
                            if (stripos($objeto->get("name"), $rule) !== false) {
                                $cumple = true;
                            }
                        } else {
                            if (stripos($objeto->get("name"), $rule) === 0) {
                                $cumple = true;
                            }
                        }
                    } elseif (stripos($rule, '*') !== false) {
                        $rule = str_replace("*", "", $rule);
                        if (substr($objeto->get("name"), strlen($objeto->get("name")) - strlen($rule)) == $rule) {
                            $cumple = true;
                        }
                    } elseif ($rule == '_general') {
                        $cumple = true;
                    } elseif ($rule == $objeto->get("name")) {
                        $cumple = true;
                    }
                    if ($cumple) {
                        if (is_callable($funcion)) {
                            if (!call_user_func($funcion)) {
                                return false;
                            }
                        } elseif ($funcion === false) {
                            return false;
                        }
                    }
                }
                return true;
            }
        }
        return false;
    }
}
