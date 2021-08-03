<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use App\Models\Idea;
use App\Http\Livewire\SetStatus;
use Livewire;

class AdminSetStatusTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function show_page_contains_set_status_livewire_component_when_user_is_admin()
    {
        $user = User::factory()->create([
            'email' => 'yekokooo1991@gmail.com'
        ]);

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('set-status');
    }


    /** @test */
    public function show_page_does_not_contains_set_status_livewire_component_when_user_is_not_admin()
    {
        $user = User::factory()->create([
            'email' => 'test@gmail.com'
        ]);

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('set-status');
    }

    /** @test */
    public function initial_status_is_set_correctly()
    {
        $user = User::factory()->create([
            'email' => 'yekokooo1991@gmail.com'
        ]);

        $statusOne = Status::factory()->create(["id" => "2","name" => 'Considering']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea
            ])
            ->assertSet('status', $statusOne->id);
    }

    /** @test */
    public function can_set_status_is_correctly()
    {
        $user = User::factory()->create([
            'email' => 'yekokooo1991@gmail.com'
        ]);

        $statusOne = Status::factory()->create(["id" => "2","name" => 'Considering']);
        $statusTwo = Status::factory()->create(["id" => "3","name" => 'In Progress']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea
            ])
            ->set('status', $statusTwo->id)
            ->call('setStatus')
            ->assertEmitted('statusWasUpdated');

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'status_id' => $statusTwo->id
        ]);
    }
}
