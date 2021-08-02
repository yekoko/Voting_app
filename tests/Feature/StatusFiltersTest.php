<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Livewire\StatusFilters;
use App\Models\User;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Category;
use Livewire;
use App\Http\Livewire\IdeasIndex;

class StatusFiltersTest extends TestCase
{

    use RefreshDatabase;


    /** @test */

    public function index_page_contains_status_filters_livewire_component()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $this->get(route('idea.index'))
            ->assertSeeLivewire('status-filters');
    }

    /** @test */

    public function show_page_contains_status_filters_livewire_component()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $this->get(route('idea.show', $idea))
            ->assertSeeLivewire('status-filters');
    }

    /** @test */

    public function shows_correct_status_count()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["id" => 4,"name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Livewire::test(StatusFilters::class)
            ->assertSee('All Ideas (2)')
            ->assertSee('Implemented (2)');

         
    }

    /** @test */

    public function filtering_works_when_query_string_in_place()
    {
        $user = User::factory()->create();

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(["name" => 'Open']);
        $statusConsidering = Status::factory()->create(["name" => 'Considering', 'classes' => 'bg-purple text-white']);
        $statusInProgress = Status::factory()->create(["name" => 'In Progress', 'classes' => 'bg-yellow text-white']);
        $statusImplemented = Status::factory()->create(["name" => 'Implemented']);
        $statusClosed = Status::factory()->create(["name" => 'Closed']);


        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusConsidering->id
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusConsidering->id
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusInProgress->id
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusInProgress->id
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusInProgress->id
        ]);

        // $response = $this->get(route('idea.index', ['status' => 'In Progress']));

        // $response->assertSuccessful();
        
        // $response->assertDontSee('<div class="bg-purple text-white text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Considering</div>', false);

        // $response->assertSee('<div class="bg-yellow text-white text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">In Progress</div>', false);

        Livewire::withQueryParams(['status' => 'In Progress'])
             ->test(IdeasIndex::class)
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 3 
                    && $ideas->first()->status->name === 'In Progress';
             });
         
    }

    /** @test */

    public function shows_page_does_not_show_selected_status()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["id" => 4,"name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertDontSee('border-blue text-gray-900');
         
    }

    /** @test */

    public function index_page_shows_selected_status()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["id" => 4,"name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSee('border-blue text-gray-900');
         
    }
}
