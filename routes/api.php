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

    Route::get('persons', 'Api\PersonApi@index')->name('api.persons.index');
    Route::post('persons', 'Api\PersonApi@store')->name('api.persons.store');
    Route::get('persons/{person}', 'Api\PersonApi@show')->name('api.persons.show');
    Route::patch('persons/{person}', 'Api\PersonApi@update')->name('api.persons.update');
    Route::delete('persons/{person}', 'Api\PersonApi@destroy')->name('api.persons.destroy');

    Route::get('partners/{role}', 'Api\PartnerApi@index')->name('api.partners.index');
    Route::post('partners/{role}', 'Api\PartnerApi@store')->name('api.partners.store');
    Route::get('partners/{role}/{partner}', 'Api\PartnerApi@show')->name('api.partners.show');
    Route::patch('partners/{role}/{partner}', 'Api\PartnerApi@update')->name('api.partners.update');
    Route::delete('partners/{role}/{partner}', 'Api\PartnerApi@destroy')->name('api.partners.destroy');

    Route::get('docs/{type}', 'Api\DocApi@index')->name('api.docs.index');
    Route::post('docs/{type}', 'Api\DocApi@store')->name('api.docs.store');
    Route::get('docs/{type}/{doc}', 'Api\DocApi@show')->name('api.docs.show');
    Route::patch('docs/{type}/{doc}', 'Api\DocApi@update')->name('api.docs.update');
    Route::delete('docs/{type}/{doc}', 'Api\DocApi@destroy')->name('api.docs.destroy');

    Route::get('doc_items/{type}', 'Api\DocItemApi@index')->name('api.doc_items.index');
    Route::post('doc_items/{type}/{doc}', 'Api\DocItemApi@store')->name('api.doc_items.store');
    Route::get('doc_items/{type}/{doc_item}', 'Api\DocItemApi@show')->name('api.doc_items.show');
    Route::patch('doc_items/{type}/{doc_item}', 'Api\DocItemApi@update')->name('api.doc_items.update');
    Route::delete('doc_items/{type}/{doc_item}', 'Api\DocItemApi@destroy')->name('api.doc_items.destroy');
});
