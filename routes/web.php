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

    Route::get('persons', 'PersonController@index')->name('persons.index');
    Route::get('persons/create', 'PersonController@create');
    Route::get('persons/{uuid}', 'PersonController@show');
    Route::get('persons/{uuid}/edit', 'PersonController@edit');
    Route::get('persons/{uuid}/delete', 'PersonController@delete');

    Route::get('partners/{role}', 'PartnerController@index')->name('partners.index');
    Route::get('partners/{role}/create', 'PartnerController@create');
    Route::get('partners/{role}/{uuid}', 'PartnerController@show');
    Route::get('partners/{role}/{uuid}/edit', 'PartnerController@edit');
    Route::get('partners/{role}/{uuid}/delete', 'PartnerController@delete');

    Route::get('docs/{type}', 'DocController@index')->name('docs.index');
    Route::get('docs/{type}/create', 'DocController@create');
    Route::get('docs/{type}/{uuid}', 'DocController@show');
    Route::get('docs/{type}/{uuid}/edit', 'DocController@edit');
    Route::get('docs/{type}/{uuid}/delete', 'DocController@delete');

    Route::put('docs/move', 'DocController@move');

    Route::get('doc_items/{type}', 'DocItemController@index')->name('doc_items.index');

    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/create', 'UserController@create');
    Route::get('users/{uuid}', 'UserController@show');
    Route::get('users/{uuid}/edit', 'UserController@edit');
    Route::get('users/{uuid}/delete', 'UserController@delete');

    Route::get('roles', 'RoleController@index')->name('roles.index');
    Route::get('roles/create', 'RoleController@create');
    Route::get('roles/{uuid}', 'RoleController@show');
    Route::get('roles/{uuid}/edit', 'RoleController@edit');
    Route::get('roles/{uuid}/delete', 'RoleController@delete');

    Route::get('permissions', 'PermissionController@index')->name('permissions.index');
    Route::get('permissions/create', 'PermissionController@create');
    Route::get('permissions/{uuid}', 'PermissionController@show');
    Route::get('permissions/{uuid}/edit', 'PermissionController@edit');
    Route::get('permissions/{uuid}/delete', 'PermissionController@delete');
});
