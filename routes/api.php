<?php

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('items', 'Api\ItemApi@index')->name('api.items.index');
    Route::post('items', 'Api\ItemApi@store')->name('api.items.store');
    Route::get('items/{item}', 'Api\ItemApi@show')->name('api.items.show');
    Route::patch('items/{item}', 'Api\ItemApi@update')->name('api.items.update');
    Route::delete('items/{item}', 'Api\ItemApi@destroy')->name('api.items.destroy');

    Route::get('locations', 'Api\LocationApi@index')->name('api.locations.index');
    Route::post('locations', 'Api\LocationApi@store')->name('api.locations.store');
    Route::get('locations/{location}', 'Api\LocationApi@show')->name('api.locations.show');
    Route::patch('locations/{location}', 'Api\LocationApi@update')->name('api.locations.update');
    Route::delete('locations/{location}', 'Api\LocationApi@destroy')->name('api.locations.destroy');

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

    Route::get('users', 'Api\UserApi@index')->name('api.users.index');
    Route::post('users', 'Api\UserApi@store')->name('api.users.store');
    Route::get('users/{user}', 'Api\UserApi@show')->name('api.users.show');
    Route::patch('users/{user}', 'Api\UserApi@update')->name('api.users.update');
    Route::delete('users/{user}', 'Api\UserApi@destroy')->name('api.users.destroy');

    Route::get('roles', 'Api\RoleApi@index')->name('api.roles.index');
    Route::post('roles', 'Api\RoleApi@store')->name('api.roles.store');
    Route::get('roles/{role}', 'Api\RoleApi@show')->name('api.roles.show');
    Route::patch('roles/{role}', 'Api\RoleApi@update')->name('api.roles.update');
    Route::delete('roles/{role}', 'Api\RoleApi@destroy')->name('api.roles.destroy');

    Route::get('permissions', 'Api\PermissionApi@index')->name('api.permissions.index');
    //Route::post('permissions', 'Api\PermissionApi@store')->name('api.permissions.store');
    Route::get('permissions/{permission}', 'Api\PermissionApi@show')->name('api.permissions.show');
    //Route::patch('permissions/{permission}', 'Api\PermissionApi@update')->name('api.permissions.update');
    //Route::delete('permissions/{permission}', 'Api\PermissionApi@destroy')->name('api.permissions.destroy');

    Route::get('profiles/account', 'Api\ProfileApi@account_show')->name('api.profiles.account_show');
    Route::get('profiles/settings', 'Api\ProfileApi@settings_show')->name('api.profiles.settings_show');
    Route::get('profiles/activities', 'Api\ProfileApi@activities_show')->name('api.profiles.activities_show');

    Route::patch('profiles/account', 'Api\ProfileApi@account_update')->name('api.profiles.account_update');
    Route::patch('profiles/password', 'Api\ProfileApi@password_update')->name('api.profiles.password_update');
    Route::patch('profiles/settings', 'Api\ProfileApi@settings_update')->name('api.profiles.settings_update');

    Route::get('countries', 'Api\CountryApi@index')->name('api.countries.index');
    Route::post('countries', 'Api\CountryApi@store')->name('api.countries.store');
    Route::get('countries/{country}', 'Api\CountryApi@show')->name('api.countries.show');
    Route::patch('countries/{country}', 'Api\CountryApi@update')->name('api.countries.update');
    Route::delete('countries/{country}', 'Api\CountryApi@destroy')->name('api.countries.destroy');

    Route::get('provinces', 'Api\ProvinceApi@index')->name('api.provinces.index');
    Route::post('provinces', 'Api\ProvinceApi@store')->name('api.provinces.store');
    Route::get('provinces/{province}', 'Api\ProvinceApi@show')->name('api.provinces.show');
    Route::patch('provinces/{province}', 'Api\ProvinceApi@update')->name('api.provinces.update');
    Route::delete('provinces/{province}', 'Api\ProvinceApi@destroy')->name('api.provinces.destroy');

    Route::get('districts', 'Api\DistrictApi@index')->name('api.districts.index');
    Route::post('districts', 'Api\DistrictApi@store')->name('api.districts.store');
    Route::get('districts/{district}', 'Api\DistrictApi@show')->name('api.districts.show');
    Route::patch('districts/{district}', 'Api\DistrictApi@update')->name('api.districts.update');
    Route::delete('districts/{district}', 'Api\DistrictApi@destroy')->name('api.districts.destroy');

    Route::get('cities', 'Api\CityApi@index')->name('api.cities.index');
    Route::post('cities', 'Api\CityApi@store')->name('api.cities.store');
    Route::get('cities/{city}', 'Api\CityApi@show')->name('api.cities.show');
    Route::patch('cities/{city}', 'Api\CityApi@update')->name('api.cities.update');
    Route::delete('cities/{city}', 'Api\CityApi@destroy')->name('api.cities.destroy');
});
