<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Company::class => \App\Policies\CompanyPolicy::class,
        \App\Doc::class => \App\Policies\DocPolicy::class,
        \App\DocItem::class => \App\Policies\DocItemPolicy::class,
        \App\Item::class => \App\Policies\ItemPolicy::class,
        \App\Location::class => \App\Policies\LocationPolicy::class,
        \App\Partner::class => \App\Policies\PartnerPolicy::class,
        \App\Person::class => \App\Policies\PersonPolicy::class,
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Role::class => \App\Policies\RolePolicy::class,
        \App\Permission::class => \App\Policies\PermissionPolicy::class,
        \App\Country::class => \App\Policies\CountryPolicy::class,
        \App\Province::class => \App\Policies\ProvincePolicy::class,
        \App\District::class => \App\Policies\DistrictPolicy::class,
        \App\City::class => \App\Policies\CityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
