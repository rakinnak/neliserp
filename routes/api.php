<?php

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('items', 'Api\ItemApi@index')->name('api.items.index');
    Route::post('items', 'Api\ItemApi@store')->name('api.items.store');
    Route::get('items/{item}', 'Api\ItemApi@show')->name('api.items.show');
    Route::patch('items/{item}', 'Api\ItemApi@update')->name('api.items.update');
    Route::delete('items/{item}', 'Api\ItemApi@destroy')->name('api.items.destroy');

    Route::get('companies', 'Api\CompanyApi@index')->name('api.companies.index');
    Route::post('companies', 'Api\CompanyApi@store')->name('api.companies.store');
    Route::get('companies/{item}', 'Api\CompanyApi@show')->name('api.companies.show');
    Route::patch('companies/{item}', 'Api\CompanyApi@update')->name('api.companies.update');
    Route::delete('companies/{item}', 'Api\CompanyApi@destroy')->name('api.companies.destroy');
});
