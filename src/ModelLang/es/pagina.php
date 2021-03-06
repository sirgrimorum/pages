<?php

return [
    "labels" => [
        "pagina" => "Página",
        "paginas" => "Páginas",
        "plural" => "Páginas",
        "singular" => "Página",
                "name" => "Nombre",
                "link" => "Enlace",
                "menu" => "Menu",
                "template" => "Plantilla",
                "order" => "Posición",
                "activo" => "Activa",
                "created_at" => "Created at",
                "updated_at" => "Updated at",
                "sections" => "Secciones",
                "edit" => "Guardar cambios",
        "create" => "Crear página",
        "show" => "Ver",
        "remove" => "Eliminar",
    ],
    "placeholders" => [
                "name" => "Nombre de la página",
                "link" => "Enlace amigable",
                "menu" => "Nombre en el menú",
                "template" => "Plantilla",
                "order" => "Posición",
                "activo" => "Activa",
                "created_at" => "Created at",
                "updated_at" => "Updated at",
                "sections" => "Secciones",
            ],
    "descriptions" => [
                "name" => "Nombre",
                "link" => "Enlace amigable a usar para la conexión",
                "menu" => "Nombre que aparece en el menú",
                "template" => "Plantilla del encabezado de la página. Recuerde poner {%%sections%%} en el lugar donde desea que se carguen las secciones. Si no lo pone, las secciones se cargarán después de esta plantilla.",
                "order" => "Ubicación respecto a las otras páginas",
                "activo" => "Si se debe mostrar o no",
                "created_at" => "Created at",
                "updated_at" => "Updated at",
                "sections" => "Secciones de la página",
            ],
    "selects" => [
        "{field}" => [
            "{value1}" => "{option1}",
            "{value2}" => "{option2}",
        ],
    ],
    "titulos" => [
        "index" => "Páginas",
        "create" => "Crear página",
        "edit" => "Editar página",
        "show" => "Ver página",
        "remove" => "Eliminar páginas"
    ],
    "messages" => [
        'confirm_destroy' => '¿Está seguro que quiere eliminar la Página ":modelName"?',
        'destroy_success' => '<strong>Listo!</strong> la Página ":modelName" ha sido eliminada',
        'update_success' => '<strong>Listo!</strong> Todos los cambios en la Página ":modelName" han sido guardados',
        'store_success' => '<strong>Listo!</strong> La Página ":modelName" ha sido creada',
        'not_found' => '<strong>Lo lamentamos!</strong> La página ":modelName" no ha sido encontrada.',
        'no_access' => '<strong>Lo lamentamos!</strong> Usted no tiene permiso para ver la página ":modelName". Por favor comuníquese con el administrador.',
    ],
        ];

