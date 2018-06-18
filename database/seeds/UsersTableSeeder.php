<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,10) as $i) {

    		DB::table('users')->insert([
    			'fname' => 'Mr.',
    			'lname' => 'admin',
    			'email' => str_random(10).'@gmail.com',
    			'password' => bcrypt('secret'),
    		]);

    	
    		// for single enter with specified name 
    		// it needs factory faker to create the faker values
    	 // $user = factory(App\User::class)->create([
      //        'email' => 'admin@gmail.com',
      //        'password' => bcrypt('admin'),
      //        'fname' => 'Mr',
      //        'lname' => 'admin'
      //    ]);
}}}
