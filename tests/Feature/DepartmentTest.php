<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Department;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentTest extends TestCase
{
    
 public function testExample()
    {
      $depart = new Department(['name'=>'Math']);
      $this->assertEquals('Math', $depart->name);
    }

    public function have_5_users(){
    	$this->assertEquals(5, Department::count());
    }

        public function test_follows()
{
    $userA = User::find(3);
    $userB = User::find(4);

    $userA->follows($userB);

    $this->assertEquals(3, $userA->following()->count());
}

public function test_unfollows()
{
    $userA = User::find(4);
    $userB = User::find(3);

    $userA->unfollows($userB);

    $this->assertEquals(0, $userA->following()->count());
}

public function test_A_follows_B_and_C()
{
    $userA = User::find(1);

    $ids = collect([ 2, 3, 4, 5]);
    $random_ids = $ids->random(2);

    $userB = User::find($random_ids->pop());
    $userC = User::find($random_ids->pop());

    $userA->follows($userB);
    $userA->follows($userC);

    $this->assertEquals(2, $userA->following()->count());
}
}
