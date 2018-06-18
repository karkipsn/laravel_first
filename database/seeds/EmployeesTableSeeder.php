<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Department;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {$faker = Faker::create();

    	foreach (range(1,10) as $i) {
           
    		DB::table('employees')->insert([
    			'name' => $faker->name,
    			'add' => $faker->address,
    			'date_hired' =>  $faker->date($format = 'Y-m-d', $max = 'now'),
    			'birthdate' => $faker-> date($format = 'Y-m-d', $max = 'now'),
    			'department_id' => $faker->numberBetween($min = 1, $max = 5),
    			 'created_at' => $faker->dateTime($max = 'now'),
                'updated_at' => $faker->dateTime($max = 'now'),
                'deleted_at' => $faker->dateTime($max = 'now'),


    		]);
    	
    }
}}

