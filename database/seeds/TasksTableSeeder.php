<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {$faker = Faker::create();

    	foreach (range(1,10) as $i) {
           
    		DB::table('tasks')->insert([
    			'employee_id' => $faker->numberBetween($min = 4000, $max = 4010),
    			'title' => $faker->sentence(10),
    			'description' => $faker->sentence(10),
    			'attachment' =>  $faker->image($dir, $width, $height, 'cats', false) ,
    			'deadline' => $faker-> date($format = 'Y-m-d', $max = 'now'),
    			 'created_at' => $faker->dateTime($max = 'now'),
                'updated_at' => $faker->dateTime($max = 'now'),
                


    		]);
    	
    }
}}

