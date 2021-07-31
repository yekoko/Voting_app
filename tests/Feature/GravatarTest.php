<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Http;

class GravatarTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    public function user_can_generate_gravatar_default_image_no_email_found_first_character_a()
    {
         $user = User::factory()->create([
            'name' => 'testuser',
            'email' => 'atest@gmail.com'
         ]);

         $gravatarUrl = $user->getAvatar();

         $this->assertEquals("https://gravatar.com/avatar/".md5($user->email)."?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-1.png", $gravatarUrl);

         $response = Http::get($user->getAvatar());

         $this->assertTrue($response->successful());
    }

    /** @test */

    public function user_can_generate_gravatar_default_image_no_email_found_first_character_z()
    {
         $user = User::factory()->create([
            'name' => 'testuser',
            'email' => 'ztest@gmail.com'
         ]);

         $gravatarUrl = $user->getAvatar();

         $this->assertEquals("https://gravatar.com/avatar/".md5($user->email)."?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-26.png", $gravatarUrl);

         $response = Http::get($user->getAvatar());

         $this->assertTrue($response->successful());
    }

    /** @test */

    public function user_can_generate_gravatar_default_image_no_email_found_first_character_0()
    {
         $user = User::factory()->create([
            'name' => 'testuser',
            'email' => '0test@gmail.com'
         ]);

         $gravatarUrl = $user->getAvatar();

         $this->assertEquals("https://gravatar.com/avatar/".md5($user->email)."?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-27.png", $gravatarUrl);

         $response = Http::get($user->getAvatar());

         $this->assertTrue($response->successful());
    }

    /** @test */

    public function user_can_generate_gravatar_default_image_no_email_found_first_character_9()
    {
         $user = User::factory()->create([
            'name' => 'testuser',
            'email' => '9test@gmail.com'
         ]);

         $gravatarUrl = $user->getAvatar();

         $this->assertEquals("https://gravatar.com/avatar/".md5($user->email)."?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-36.png", $gravatarUrl);

         $response = Http::get($user->getAvatar());

         $this->assertTrue($response->successful());
    }
}
