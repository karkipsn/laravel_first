<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
     public function test_login()
    {
        $this->browse(function ($browser) {
            $browser->visit('login')
                    ->type('email', 'whXjFUpgIc@gmail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                     ->assertPathIs('/users');
        });
    }}
