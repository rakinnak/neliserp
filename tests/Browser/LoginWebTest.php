<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Item;
use App\User;

class LoginWebTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_must_be_login_before_use()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login');
        });
    }

    /** @test */
    public function invalid_user_cannot_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('username', 'unknown')
                ->type('password', 'invalid')
                ->press('login')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records');
        });
    }

    /** @test */
    public function valid_user_can_login()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('secret'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('username', $user->username)
                ->type('password', 'secret')
                ->press('login')
                ->assertPathIs('/');
        });
    }
}
