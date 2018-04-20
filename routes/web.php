<?php

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth:web']], function() {
    Route::get('/', 'PageController@home');
    Route::get('docs', 'DocController@index');
    Route::get('items', 'ItemController@index');
    Route::get('companies', 'CompanyController@index');
    Route::get('reports', 'ReportController@index');
});
