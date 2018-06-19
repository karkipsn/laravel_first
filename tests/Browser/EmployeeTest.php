<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EmployeeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
          $this->browse(function ($browser) {
            $browser->visit('http://localhost:8000/employees/create') //Go to the homepage
                    ->clickLink('Create ') //Click the Register link
                    ->assertSee('Create') //Make sure the phrase in the arguement is on the page
            //Fill the form with these values
                    ->value('#name', 'Joe') 
                    ->value('#add', 'Kumaripati') 
                    ->value('#birthdate', '2018-06-13')
                    ->value('#date_hired', '2018-06-13')
                    ->value('#department_id', '1')
                    ->click('button[type="submit"]') //Click the submit button on the page
                    ->assertPathIs('/users/index') //Make sure you are in the home page
            //Make sure you see the phrase in the arguement
                    ->assertSee("ID"); 
        });
    }
}
