<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

use App\User;
use App\Permission;
use App\Role;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless'
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();
    
        $this->actingAs($user, 'api');
    
        return $this;
    }

    protected function signInWithPermission($permission_name)
    {
        $permission = factory(Permission::class)->create(['name' => $permission_name]);
    
        $role = factory(Role::class)->create();
        $role->givePermissionTo($permission);
    
        $user = factory(User::class)->create();
        $user->assignRole($role->name);
    
        $this->actingAs($user, 'api');
    }
}
