<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Idea;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;

class ShowIdeasTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function list_of_ideas_show_on_main_page()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);
        $statusTwo = Status::factory()->create(["name" => 'Considering', "classes" =>  "bg-purple text-white"]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Second Title',
            'category_id' => $catTwo->id,
            'status_id' => $statusTwo,
            'description' => 'Test Second Description'
        ]);

        $this->get(route('idea.index'))
             ->assertSuccessful()
             ->assertSee($ideaOne->title)
             ->assertSee($ideaOne->description)
             ->assertSee($catOne->name)
             ->assertSee('<div class="bg-gray-200 text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Open</div>', false)
             ->assertSee($ideaTwo->title)
             ->assertSee($ideaTwo->description)
             ->assertSee($catTwo->name)
             ->assertSee('<div class="bg-purple text-white text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Considering</div>', false);
    }

    /** @test */

    public function single_ideas_shows_on_the_show_page()
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
             ->assertSuccessful()
             ->assertSee($idea->title)
             ->assertSee($idea->description)
             ->assertSee($idea->category->name)
             ->assertSee($idea->status->classes);
    }

    /** @test */
    
    public function ideas_pagination_works()
    {
        $user = User::factory()->create();
        
        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']); 

        Idea::factory(16)->create(['user_id' => $user->id, 'category_id' => $catOne->id, 'status_id' => $statusOne->id, ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My First Title';
        $ideaOne->save();

        $ideaEleven = Idea::find(16);
        $ideaEleven->title = 'My Eleventh Title';
        $ideaEleven->save();


        $this->get('/')
             ->assertDontSee($ideaOne->title)
             ->assertSee($ideaEleven->title);

        $this->get('/?page=2')
             ->assertSee($ideaOne->title)
             ->assertDontSee($ideaEleven->title);
    }

    /** @test */
    
    public function some_idea_title_different_slugs()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);
        $catOne = Category::factory()->create(['name' => 'Category 1']); 

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Second Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Second Description'
        ]);


        $this->get(route('idea.show', $ideaOne))
             ->assertSuccessful();
             
        $this->assertTrue(request()->path() === 'idea/my-first-title');

        $this->get(route('idea.show', $ideaTwo))
             ->assertSuccessful();

        $this->assertTrue(request()->path() === 'idea/my-second-title') ;
    }


    /** @test */

    public function back_button_works_when_index_page_visited_first()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);
        $statusTwo = Status::factory()->create(["name" => 'Considering', "classes" =>  "bg-purple text-white"]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        $response = $this->get('/?category=Category%202&status=Considering');
        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertStringContainsString('/?category=Category%202&status=Considering', $response['back_url']);
        
    }

    /** @test */

    public function back_button_works_when_show_page_only_visited()
    {
        $user = User::factory()->create();

        $statusOne = Status::factory()->create(["name" => 'Open', "classes" =>  "bg-gray-200" ]);
        $statusTwo = Status::factory()->create(["name" => 'Considering', "classes" =>  "bg-purple text-white"]);

        $catOne = Category::factory()->create(['name' => 'Category 1']);
        $catTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Title',
            'category_id' => $catOne->id,
            'status_id' => $statusOne->id,
            'description' => 'Test Description'
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertEquals(route('idea.index'), $response['back_url']);
        
    }
}
