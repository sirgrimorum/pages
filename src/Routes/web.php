<?php

if (config('sirgrimorum.pages.with_routes', true)) {
    if (config('sirgrimorum.pages.localized', true)) {
        Route::group(['prefix' => CrudGenerator::setLocale(), 'middleware' => ['web', 'crudgenlocalization']], function () {
            Route::group(['prefix' => trans('pages::pages'), 'as' => config('sirgrimorum.pages.group_name', 'paginas.')], function() {
                Route::get('', '\Sirgrimorum\Pages\PaginaController@index')->name('index');
                Route::get('/{paginaName}', '\Sirgrimorum\Pages\PaginaController@show')->name('show');
            });
        });
    } else {
        Route::group(['prefix' => config('sirgrimorum.pages.group_prefix', ''), 'as' => config('sirgrimorum.pages.group_name', 'paginas.')], function() {
            Route::get('', '\Sirgrimorum\Pages\PaginaController@index')->name('index');
            Route::get('/{paginaName}', '\Sirgrimorum\Pages\PaginaController@show')->name('show');
        });
    }
}