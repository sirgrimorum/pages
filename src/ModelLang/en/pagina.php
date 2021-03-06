<?php

return [
    "labels" => [
        "pagina" => "Page",
        "paginas" => "Pages",
        "plural" => "Pages",
        "singular" => "Page",
                "name" => "Name",
                "link" => "Link",
                "menu" => "Menu",
                "template" => "Template",
                "order" => "Position",
                "activo" => "Active",
                "created_at" => "Created at",
                "updated_at" => "Updated at",
                "sections" => "Sections",
                "edit" => "Save changes",
        "create" => "Create page",
        "show" => "Show",
        "remove" => "Delete",
    ],
    "placeholders" => [
                "name" => "Name",
                "link" => "Link",
                "menu" => "Menu",
                "template" => "Template",
                "order" => "Position",
                "activo" => "Active",
                "created_at" => "Created at",
                "updated_at" => "Updated at",
                "sections" => "Sections",
            ],
    "descriptions" => [
                "name" => "Name for the page",
                "link" => "Link to use",
                "menu" => "Name as it will appear in the menu",
                "template" => "Header template for the page. Remember to use {%%sections%%} in the place where you want the sections to be loaded. Don use it an the sections will be lodaded after this template.",
                "order" => "Position relative to the other pages in the site",
                "activo" => "Whether to show this page or not",
                "created_at" => "Created at",
                "updated_at" => "Updated at",
                "sections" => "Sections",
            ],
    "selects" => [
        "{field}" => [
            "{value1}" => "{option1}",
            "{value2}" => "{option2}",
        ],
    ],
    "titulos" => [
        "index" => "Pages",
        "create" => "Create page",
        "edit" => "Edit page",
        "show" => "Show page",
        "remove" => "Remove pages"
    ],
    "messages" => [
        'confirm_destroy' => 'Are you sure to delete ":modelName"?',
        'destroy_success' => '<strong>Great!</strong> ":modelName" has been deleted',
        'update_success' => '<strong>Great!</strong> All changes to ":modelName" have been saved',
        'store_success' => '<strong>Great!</strong> ":modelName" has been created',
        'not_found' => '<strong>We are sorry!</strong> The page ":modelName" has not been found.',
        'no_access' => '<strong>We are sorry!</strong> You are not allow to see the page ":modelName". Please contact the administrator.',
    ],
        ];

