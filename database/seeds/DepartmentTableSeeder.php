<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	 $depts = collect(['MBBS', 'Civil', 'Computer', 'IT', 'Arts']);

     
    	// foreach (range(1,5) as $i) {

        	$depts->each(function($deptName) {

        		factory('App\Department')->create([
        		'name' => $deptName
        		]);
        	});



    
}
}
