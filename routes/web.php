<?php

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth:web']], function() {
    Route::get('/', 'PageController@home');
    Route::get('items', 'ItemController@index');
});
