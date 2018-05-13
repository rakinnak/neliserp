<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Company;
use App\Doc;
use App\DocItem;
use App\Item;
use App\Location;
use App\Partner;
use App\Person;
use App\User;
use App\Role;
use App\Permission;
use App\Country;
use App\Province;
use App\District;
use App\City;
use App\Policies\CompanyPolicy;
use App\Policies\DocPolicy;
use App\Policies\DocItemPolicy;
use App\Policies\ItemPolicy;
use App\Policies\LocationPolicy;
use App\Policies\PartnerPolicy;
use App\Policies\PersonPolicy;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\CountryPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\DistrictPolicy;
use App\Policies\CityPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Company::class => CompanyPolicy::class,
        Doc::class => DocPolicy::class,
        DocItem::class => DocItemPolicy::class,
        Item::class => ItemPolicy::class,
        Location::class => LocationPolicy::class,
        Partner::class => PartnerPolicy::class,
        Person::class => PersonPolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Country::class => CountryPolicy::class,
        Province::class => ProvincePolicy::class,
        District::class => DistrictPolicy::class,
        City::class => CityPolicy::class,
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
