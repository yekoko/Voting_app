<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Livewire;
use App\Http\Livewire\IdeasIndex;

class CategoryFiltersTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function selecting_a_category_filters_correctly()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catTwo->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Livewire::test(IdeasIndex::class)
             ->set('category', 'Category 1')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 2 && $ideas->first()->category->name === 'Category 1';
             });
    }

    /** @test */
    public function category_query_string_filters_correctly()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catTwo->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Livewire::withQueryParams(['category' => 'Category 1'])
             ->test(IdeasIndex::class)
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 2 && $ideas->first()->category->name === 'Category 1';
             });
    }

    /** @test */
    public function selecting_a_status_and_a_category_filters_correctly()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Implemented']);
        $statusTwo = Status::factory()->create(["name" => 'Considering']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusTwo->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catTwo->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaFour = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catTwo->id,
            'status_id' => $statusTwo->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Livewire::test(IdeasIndex::class)
             ->set('status', 'Implemented')
             ->set('category', 'Category 1')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 1 
                    && $ideas->first()->category->name === 'Category 1' 
                    && $ideas->first()->status->name === 'Implemented';
             });
    }

    /** @test */
    public function category_query_string_filters_correctly_with_status_and_category()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Implemented']);
        $statusTwo = Status::factory()->create(["name" => 'Considering']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusTwo->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catTwo->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaFour = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catTwo->id,
            'status_id' => $statusTwo->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        Livewire::withQueryParams(['status' => 'Implemented','category' => 'Category 1'])
             ->test(IdeasIndex::class)
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 1 
                    && $ideas->first()->category->name === 'Category 1' 
                    && $ideas->first()->status->name === 'Implemented';
             });
    }

    /** @test */
    public function selecting_all_categories_filters_correctly()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My Second Title',
            'description' => 'Test Description'
        ]);

        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $catTwo->id,
            'status_id' => $statusOne->id,
            'title' => 'My Third Title',
            'description' => 'Test Description'
        ]);

        Livewire::test(IdeasIndex::class)
             ->set('category', 'All Categories')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 3 ;
             });
    }
}
