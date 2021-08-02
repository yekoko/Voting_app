<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\Vote;
use Livewire;
use App\Http\Livewire\IdeasIndex;

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function searching_works_when_more_than_3_characters()
    {
        $user = User::factory()->create();
        
        $statusOne = Status::factory()->create(["name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        

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
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My Third Title',
            'description' => 'Test Description'
        ]);

        Livewire::test(IdeasIndex::class)
             ->set('search', 'Second')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 1 
                && $ideas->first()->title === 'My Second Title' ;
             });
    }

    /** @test */
    public function does_not_preform_search_if_less_than_3_characters()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Implemented']);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        

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
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My Third Title',
            'description' => 'Test Description'
        ]);

        Livewire::test(IdeasIndex::class)
             ->set('search', 'a')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 3 ;
             });
    }

    /** @test */
    public function search_work_correctly_with_category_filter()
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
             ->set('category', 'Category 1')
             ->set('search', 'Title')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 2 ;
             });
    }
}
