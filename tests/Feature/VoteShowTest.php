<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Vote;
use Livewire;
use App\Http\Livewire\IdeaShow;

class VoteShowTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    public function show_page_contains_idea_show_livewire_component()
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

        $this->get(route('idea.show', $idea))
             ->assertSeeLivewire('idea-show');
    }

    /** @test */

    public function show_page_correctly_receives_vote_count()
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

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $userTwo->id
        ]);

        $this->get(route('idea.show', $idea))
             ->assertViewHas('voteCount', 2);
    }

    /** @test */

    public function votes_count_shows_correctly_on_livewire_component()
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

        Livewire::test(IdeaShow::class, [
            'idea' => $idea,
            'voteCount' => 2
        ])->assertSet('voteCount', 2)
        ->assertSeeHtml('<div class="text-xl leading-snug ">2</div>')
        ->assertSeeHtml('<div class="text-sm font-bold leading-none ">2</div>');
    }


    /** @test */

    public function login_user_show_voted_if_already_voted_for()
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

        // testing with index blade 
        // $response = $this->actingAs($user)->get(route('idea.index'));
        // $ideaWithVotes = $response['ideas']->items()[0];
        // Livewire::actingAs($user)
        //     ->test(IdeaShow::class, [
        //         'idea' => $ideaWithVotes,
        //         'voteCount' => 2
        //     ])
        //     ->assertSet('hasVoted', true)
        //     ->assertSee('Voted');

        $idea->vote_count = 1;
        $idea->voted_by_user = 1;

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'voteCount' => 2
            ])
            ->assertSet('hasVoted', true)
            ->assertSee('Voted');
    }

    /** @test */

    public function user_is_not_login_redirect_to_login_page_when_try_to_vote()
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

        Livewire::test(IdeaShow::class, [
                'idea' => $idea,
                'voteCount' => 2
            ])
            ->call('vote')
            ->assertRedirect(route('login'));
    }

    /** @test */

    public function user_who_is_login_can_vote()
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

        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'voteCount' => 2
            ])
            ->call('vote')
            ->assertSet('voteCount', 3)
            ->assertSet('hasVoted', true)
            ->assertSee('Voted');

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id
        ]);
    }
}
