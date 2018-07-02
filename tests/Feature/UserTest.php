<?php

namespace Tests\Feature;
use App\User;

use Tests\TestCase;
use DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



class UserTest extends TestCase
{

    public function test_have_10_users()
    {
        $this->assertEquals(10, User::count());
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

    $ids = collect([ 3, 4, 5, 6, 7, 8, 9, 10]);
    $random_ids = $ids->random(2);

    $userB = User::find($random_ids->pop());
    $userC = User::find($random_ids->pop());

    $userA->follows($userB);
    $userA->follows($userC);

    $this->assertEquals(2, $userA->following()->count());
}
}

