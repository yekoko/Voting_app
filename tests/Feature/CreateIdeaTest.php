<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use Livewire;
use App\Http\Livewire\CreateIdea;

class CreateIdeaTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    public function create_idea_form_does_not_show_is_not_login_user()
    {
        $response = $this->get(route('idea.index'));

        $response->assertSuccessful()
                ->assertSee('Please login to create an idea.')
                ->assertDontSee('Let us know what you would like and we\'ll take look');
    }

    /** @test */

    public function create_idea_form_show_only_login_user()
    {
        $response = $this->actingAs(User::factory()->create())->get(route('idea.index'));

        $response->assertSuccessful()
                ->assertDontSee('Please login to create an idea.')
                ->assertSee('Let us know what you would like and we\'ll take look', false);
    }

    /** @test */

    public function main_page_contain_create_idea_livewire_component()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('idea.index'))
            ->assertSeeLivewire('create-idea');

    }

    /** @test */

    public function create_idea_form_validation_works()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', '')
            ->set('category', '')
            ->set('description', '')
            ->call('createIdea')
            ->assertHasErrors(['title', 'category', 'description'])
            ->assertSee('The title field is required.');
    }

    /** @test */

    public function creating_an_idea_works_correctly()
    {
        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        //$catTwo = Category::factory()->create(['name' => 'Category 2']);

        $attributes = [
            'title' => 'My First Idea',
            'description' => 'My description',
        ];

        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', $attributes['title'])
            ->set('category', $catOne->id)
            ->set('description', $attributes['description'])
            ->call('createIdea')
            ->assertRedirect('/');

        $this->actingAs(User::factory()->create())
            ->get(route('idea.index'))
            ->assertSuccessful()
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description']);

        $this->assertDatabaseHas('ideas', [
            'title' => $attributes['title'],
            'description' => $attributes['description']
        ]);
    }

    /** @test */

    public function creating_two_ideas_same_title_but_differrent_slugs()
    {
        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        //$catTwo = Category::factory()->create(['name' => 'Category 2']);

        $attributes = [
            'title' => 'My First Idea',
            'description' => 'My description',
            'slug' => 'my-first-idea'
        ];

        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', $attributes['title'])
            ->set('category', $catOne->id)
            ->set('description', $attributes['description'])
            ->call('createIdea')
            ->assertRedirect('/');

        $this->assertDatabaseHas('ideas', [
            'title' => $attributes['title'],
            'slug' => $attributes['slug']
        ]);

        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', $attributes['title'])
            ->set('category', $catOne->id)
            ->set('description', $attributes['description'])
            ->call('createIdea')
            ->assertRedirect('/');

        $this->assertDatabaseHas('ideas', [
            'title' => $attributes['title'],
            'slug' => 'my-first-idea-2'
        ]);
    }
}
