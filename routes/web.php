<?php

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth:web']], function() {
    Route::get('/', 'PageController@home');
    Route::get('reports', 'ReportController@index');

    Route::get('items', 'ItemController@index')->name('items.index');
    Route::get('items/create', 'ItemController@create');
    Route::get('items/{uuid}', 'ItemController@show');
    Route::get('items/{uuid}/edit', 'ItemController@edit');
    Route::get('items/{uuid}/delete', 'ItemController@delete');

    Route::get('companies', 'CompanyController@index')->name('companies.index');
    Route::get('companies/create', 'CompanyController@create');
    Route::get('companies/{uuid}', 'CompanyController@show');
    Route::get('companies/{uuid}/edit', 'CompanyController@edit');
    Route::get('companies/{uuid}/delete', 'CompanyController@delete');

    Route::get('docs', 'DocController@index')->name('docs.index');
    Route::get('docs/create', 'DocController@create');
    Route::get('docs/{uuid}', 'DocController@show');
    Route::get('docs/{uuid}/edit', 'DocController@edit');
    Route::get('docs/{uuid}/delete', 'DocController@delete');
});
