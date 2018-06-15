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
     public function test_I_can_login_successfully()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'psn.karki20@gmail.com')
                    ->type('password', 'psnpsn')
                    ->press('Login')
                    ->assertSee('You are logged in!');
        });
    }}
