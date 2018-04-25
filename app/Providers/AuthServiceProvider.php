<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Company;
use App\Doc;
use App\DocItem;
use App\Item;
use App\Policies\CompanyPolicy;
use App\Policies\DocPolicy;
use App\Policies\DocItemPolicy;
use App\Policies\ItemPolicy;

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
