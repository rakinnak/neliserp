<?php

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('items', 'Api\ItemApi@index')->name('api.items.index');
    Route::post('items', 'Api\ItemApi@store')->name('api.items.store');
    Route::get('items/{item}', 'Api\ItemApi@show')->name('api.items.show');
    Route::patch('items/{item}', 'Api\ItemApi@update')->name('api.items.update');
    Route::delete('items/{item}', 'Api\ItemApi@destroy')->name('api.items.destroy');

    Route::get('companies', 'Api\CompanyApi@index')->name('api.companies.index');
    Route::post('companies', 'Api\CompanyApi@store')->name('api.companies.store');
    Route::get('companies/{company}', 'Api\CompanyApi@show')->name('api.companies.show');
    Route::patch('companies/{company}', 'Api\CompanyApi@update')->name('api.companies.update');
    Route::delete('companies/{company}', 'Api\CompanyApi@destroy')->name('api.companies.destroy');

    Route::get('docs/{type}', 'Api\DocApi@index')->name('api.docs.index');
    Route::post('docs/{type}', 'Api\DocApi@store')->name('api.docs.store');
    Route::get('docs/{type}/{doc}', 'Api\DocApi@show')->name('api.docs.show');
    Route::patch('docs/{type}/{doc}', 'Api\DocApi@update')->name('api.docs.update');
    Route::delete('docs/{type}/{doc}', 'Api\DocApi@destroy')->name('api.docs.destroy');

    Route::get('doc_item/{type}', 'Api\DocItemApi@index')->name('api.doc_item.index');
    Route::post('doc_item/{type}/{doc}', 'Api\DocItemApi@store')->name('api.doc_item.store');
    Route::get('doc_item/{type}/{doc_item}', 'Api\DocItemApi@show')->name('api.doc_item.show');
    Route::patch('doc_item/{type}/{doc_item}', 'Api\DocItemApi@update')->name('api.doc_item.update');
    Route::delete('doc_item/{type}/{doc_item}', 'Api\DocItemApi@destroy')->name('api.doc_item.destroy');
});
