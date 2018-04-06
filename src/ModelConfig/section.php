<?php

return [
    "modelo" => "Sirgrimorum\Pages\Models\Section",
    "tabla" => "sections",
    "nombre" => "name",
    "id" => "id",
    "url" => "Sirgrimorum_CrudAdministrator",
    "botones" => "__trans__crudgenerator::admin.layout.labels.create",
    "campos" => [
        "name" => [
            "tipo" => "text",
            "label" => "__trans__crudgenerator::section.labels.name",
            "placeholder" => "__trans__crudgenerator::section.placeholders.name",
            "description" => "__trans__crudgenerator::section.descriptions.name", 
        ],
        "titulo" => [
            "tipo" => "article",
            "es_html" => true,
            "label" => "__trans__crudgenerator::section.labels.titulo",
            "placeholder" => "__trans__crudgenerator::section.placeholders.titulo",
            "scope" => "sections.titulo",
            "description" => "__trans__crudgenerator::section.descriptions.titulo", 
        ],
        "texto" => [
            "tipo" => "article",
            "label" => "__trans__crudgenerator::section.labels.texto",
            "placeholder" => "__trans__crudgenerator::section.placeholders.texto",
            "scope" => "sections.texto",
            "es_html" => true,
            "description" => "__trans__crudgenerator::section.descriptions.texto", 
        ],
        "order" => [
            "tipo" => "number",
            "label" => "__trans__crudgenerator::section.labels.order",
            "placeholder" => "__trans__crudgenerator::section.placeholders.order",
            "format" => [
                "0" => 0,
                "1" => ".",
                "2" => ".",
            ],
            "valor" => "1",
            "description" => "__trans__crudgenerator::section.descriptions.order", 
        ],
        "activo" => [
            "tipo" => "checkbox",
            "label" => "__trans__crudgenerator::section.labels.activo",
            "value" => true,
            "valor" => "1",
            "description" => "__trans__crudgenerator::section.descriptions.activo", 
        ],
        "pagina" => [
            "tipo" => "relationship",
            "label" => "__trans__crudgenerator::section.labels.pagina",
            "modelo" => "App\Pagina",
            "id" => "id",
            "campo" => "name",
            "todos" => "",
            "description" => "__trans__crudgenerator::section.descriptions.pagina", 
        ],
    ],
    "rules" => [
        "name" => "bail|max:150|required",
        "titulo" => "bail|with_articles",
        "texto" => "bail|with_articles",
        "order" => "bail|required",
        "pagina" => "bail|required|exists:paginas,id",
    ],
];