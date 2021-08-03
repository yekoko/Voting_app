<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
   use RefreshDatabase;


   /** @test */

    public function can_check_if_user_is_an_admin()
    {
        $user = User::factory()->make([
            'name' => 'yekoko',
            'email' => 'yekokooo1991@gmail.com'
        ]);

        $userTwo = User::factory()->make([
            'name' => 'test user',
            'email' => 'tyundt@example.net'
        ]);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($userTwo->isAdmin());
    }
}
