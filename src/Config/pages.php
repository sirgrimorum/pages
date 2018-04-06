<?php

return[
    /**
     * Default Model for the paginas table
     */
    'default_paginas_model' => 'Sirgrimorum\Pages\Models\Pagina',
    /**
     * Default Model for the sections table
     */
    'default_sections_model' => 'Sirgrimorum\Pages\Models\Section',
    /**
     * Whether to register routes or not
     */
    'with_routes' => true,
    /**
     * Whether to use localized routes or not
     */
    'localized' => true,
    /**
     * Route group base name ('as' attribute)
     */
    'group_name' => 'paginas.',
    /**
     * Route group prefix (the base direction in the url), 
     * used in not localized version otherwise will be loaded from the Lang file
     */
    'group_prefix' => '',
    /**
     * The blade to extend
     */
    'extends' => 'layouts.app',
    /**
     * Content section name
     */
    'content' => 'content',
    /**
     * Js to load
     */
    'jses' => [
        'js/pagina.js',
    ],
    /**
     * stack name for the js section
     */
    'js_section' => config("sirgrimorum.crudgenerator.js_section"),
    /**
     * Css to load
     */
    'csses' => [
        'js/pagina.css',
    ],
    /**
     * stack name for the css section
     */
    'css_section' => config("sirgrimorum.crudgenerator.css_section"),
    /**
     * Special sections lodaded from blade templates an models
     * The replacements will be done in order, so it is possible to nest them in the blade templates
     */
    'special_sections' => [
        '[name]'=>[ //The name between the {%% %%} in the content or title of the section or the template of the page to be replaced
            'pre_html' => 'html_tags', //the html to instert before the blade
            'blade' => 'blade.include.name', //the blade to load for the item
            'post_html' => 'html_tags', //the html to instert after the blade
            'type' => 'simple', //type of section, options are: 'simple' (just load the blade template), 'collection' (load the blade for each object in a collection), 'model' (load the blade for every registry of a certain model)
            'parameters' => [], //array of parameters to pass to the blade, this will be merged with an array with ['user', 'pagina', 'special_section', '{object_name (only for the 'model' and 'collection' types}']
            'collection' => [ // the collection with the objects or the details to constructir, only for the 'collection' type
                'class' => 'App\Modelname', // Class name
                'isModel' => false, // The class is a model
                'query' => " id = '1'", // For whereRaw, or empty or not present for ->all()
                'orderBy' => 'field', //if needs ordering, the field
                'order' => 'asc', // if needed. default is asc
                'attribute' => 'attributeName', // only when the 'isModel' option is true
                'function' => 'functionName', //only when the 'isModel' option is true
            ], 
            'model' => 'App\Modelname', // The model class to load, only for the 'model' type
            'object_name' => 'variable_name' // The name of the variable with the object to pass in the parameters to the blade, only for the 'collection' and 'model' types
        ]
    ],
    
    /**
     * Define who could see the paginas. False mean not able to see it.
     * Policies are evaluated in order, and all must be fulfilled
     */
    'paginas_policies' =>[
        '_general' => function(){ //for all the paginas
            return true;
        },
        '*pagina_name' => function(){ //for all paginas wich name ends with 'pagina_name'
            return Auth::check();
        },
        'pagina_name*' => function(){ //for all paginas wich name starts with 'pagina_name'
            return Auth::check();
        },
        '*pagina_name*' => function(){ //for all paginas wich name contains 'pagina_name'
            return Auth::check();
        },
        'pagina_name' => function(){ //for the pagina with the name 'pagina_name'
            return Auth::check();
        },
    ],
    /**
     * Define who could see the sections. False mean not able to see it.
     * Policies are evaluated in order, and all must be fulfilled
     */
    'sections_policies' =>[
        '_general' => function(){ //for all the sections
            return true;
        },
        '*section_name' => function(){ //for all sections wich name ends with 'section_name'
            return Auth::check();
        },
        'section_name*' => function(){ //for all sections wich name starts with 'section_name'
            return Auth::check();
        },
        '*section_name*' => function(){ //for all sections wich name contains 'section_name'
            return Auth::check();
        },
        'section_name' => function(){ //for the sections with the name 'section_name'
            return Auth::check();
        },
    ],
];
