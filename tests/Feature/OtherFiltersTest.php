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

class OtherFiltersTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
    public function top_voted_filter_work_correctly()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $userThree = User::factory()->create();

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

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $user->id
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userThree->id
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $userTwo->id
        ]);

        Livewire::test(IdeasIndex::class)
             ->set('filter', 'Top Voted')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 2 
                && $ideas->first()->votes()->count() == 2 
                && $ideas->get(1)->votes()->count() == 1;
             });
    }

    /** @test */
    public function my_ideas_filter_work_correctly_when_user_logged_in()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();

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
            'user_id' => $userTwo->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My Third Title',
            'description' => 'Test Description'
        ]);

        Livewire::actingAs($user)
             ->test(IdeasIndex::class)
             ->set('filter', 'My Ideas')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 2 
                && $ideas->first()->title === "My Second Title" 
                && $ideas->get(1)->title === "My First Title";
             });
    }

    /** @test */
    public function my_ideas_filter_work_correctly_when_user_is_not_logged_in()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();

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
            'user_id' => $userTwo->id,
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'title' => 'My Third Title',
            'description' => 'Test Description'
        ]);

        Livewire::test(IdeasIndex::class)
             ->set('filter', 'My Ideas')
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function my_ideas_filter_work_correctly_with_categories_filter()
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

        Livewire::actingAs($user)
             ->test(IdeasIndex::class)
             ->set('category', 'Category 1')
             ->set('filter', 'My Ideas')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 2 
                && $ideas->first()->title === "My Second Title" 
                && $ideas->get(1)->title === "My First Title";
             });
    }

    /** @test */
    public function no_filter_work_correctly()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();

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
             ->set('filter', 'No Filter')
             ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() == 3
                && $ideas->first()->title === "My Third Title" 
                && $ideas->get(1)->title === "My Second Title";
             });
    }
}
