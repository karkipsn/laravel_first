<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
           $this->browse(function ($browser) {
            $browser->visit('http://localhost:8000/') //Go to the homepage
                    ->clickLink('Register') //Click the Register link
                    ->assertSee('Register') //Make sure the phrase in the arguement is on the page
            //Fill the form with these values
                    ->value('#fname', 'Joe') 
                    ->value('#lname', 'Allen') 
                    ->value('#email', 'pik123@example.com')
                    ->value('#password', 'secret')
                    ->value('#password-confirm', 'secret')
                    ->click('button[type="submit"]') //Click the submit button on the page
                    ->assertPathIs('/users/index') //Make sure you are in the home page
            //Make sure you see the phrase in the arguement
                    ->assertSee("ID"); 
        });
    }
}
