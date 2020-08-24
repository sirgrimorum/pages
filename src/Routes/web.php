<?php

use Illuminate\Support\Facades\Route;

if (config('sirgrimorum.pages.with_routes', true)) {
    if (config('sirgrimorum.pages.localized', true)) {
        Route::group(['middleware' => ['web', 'pages'], 'prefix' => Sirgrimorum\CrudGenerator\CrudGenerator::setLocale(), 'middleware' => ['web', 'crudgenlocalization']], function () {
            Route::group(['prefix' => Sirgrimorum\CrudGenerator\CrudGenerator::transRouteExternal('pages::pages.group_prefix') , 'as' => config('sirgrimorum.pages.group_name', 'paginas.')], function() {
                Route::get('', '\Sirgrimorum\Pages\PaginaController@index')->name('index');
                Route::get('/{paginaName}', '\Sirgrimorum\Pages\PaginaController@show')->name('show');
            });
        });
    } else {
        Route::group(['middleware' => ['web', 'pages'], 'prefix' => config('sirgrimorum.pages.group_prefix', ''), 'as' => config('sirgrimorum.pages.group_name', 'paginas.')], function() {
            Route::get('', '\Sirgrimorum\Pages\PaginaController@index')->name('index');
            Route::get('/{paginaName}', '\Sirgrimorum\Pages\PaginaController@show')->name('show');
        });
    }
}
