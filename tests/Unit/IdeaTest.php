<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteNotFoundException;
use App\Models\User;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\Vote;


class IdeaTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function can_check_if_idea_is_voted_for_by_user()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        $this->assertTrue($idea->isVotedByUser($user));
        $this->assertFalse($idea->isVotedByUser($userTwo));
        $this->assertFalse($idea->isVotedByUser(null));
    }


    /** @test */
    public function user_can_vote_for_an_idea()
    {
        $user = User::factory()->create();
        
        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        $this->assertFalse($idea->isVotedByUser($user));
        $idea->vote($user);
        $this->assertTrue($idea->isVotedByUser($user));

    }

    /** @test */
    public function voting_for_an_idea_already_voted_for_throw_exception()
    {
        $user = User::factory()->create();
        
        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        $this->expectException(DuplicateVoteException::class);

        $idea->vote($user);

    }

    /** @test */
    public function user_can_remove_vote_for_idea()
    {
        $user = User::factory()->create();
        
        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        $this->assertTrue($idea->isVotedByUser($user));
        $idea->remove_vote($user);
        $this->assertFalse($idea->isVotedByUser($user));

    }

    /** @test */
    public function removing_vote_that_does_not_exist_for_throw_exception()
    {
        $user = User::factory()->create();
        
        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);
        
        
        
        $this->expectException(VoteNotFoundException::class);

        $idea->remove_vote($user);

    }
}
