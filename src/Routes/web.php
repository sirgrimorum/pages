<?php

use Illuminate\Support\Facades\Route;

if (config('sirgrimorum.pages.with_routes', true)) {
    if (config('sirgrimorum.pages.localized', true)) {
        Route::group(['middleware' => ['web'], 'prefix' => \Sirgrimorum\CrudGenerator\CrudGenerator::setLocale(), 'middleware' => ['web', 'crudgenlocalization']], function () {
            Route::group(['middleware' => [\Sirgrimorum\Pages\Middleware\PagesRedirectMiddleware::class]], function(){
                Route::group(['prefix' => \Sirgrimorum\CrudGenerator\CrudGenerator::transRouteExternal('pages::pages.group_prefix') , 'as' => config('sirgrimorum.pages.group_name', 'paginas.')], function() {
                    Route::get('', '\Sirgrimorum\Pages\PaginaController@index')->name('index');
                    Route::get('/{paginaName}', '\Sirgrimorum\Pages\PaginaController@show')->name('show');
                });
            });
        });
    } else {
        Route::group(['middleware' => ['web'], 'prefix' => config('sirgrimorum.pages.group_prefix', ''), 'as' => config('sirgrimorum.pages.group_name', 'paginas.')], function() {
            Route::group(['middleware' => [\Sirgrimorum\Pages\Middleware\PagesRedirectMiddleware::class]], function(){
                Route::get('', '\Sirgrimorum\Pages\PaginaController@index')->name('index');
                Route::get('/{paginaName}', '\Sirgrimorum\Pages\PaginaController@show')->name('show');
            });
        });
    }
}
