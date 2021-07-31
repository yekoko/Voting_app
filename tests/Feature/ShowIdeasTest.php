<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Idea;

class ShowIdeasTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function list_of_ideas_show_on_main_page()
    {
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Title',
            'description' => 'Test Second Description'
        ]);

        $this->get(route('idea.index'))
             ->assertSuccessful()
             ->assertSee($ideaOne->title)
             ->assertSee($ideaOne->description)
             ->assertSee($ideaTwo->title)
             ->assertSee($ideaTwo->description);
    }

    /** @test */

    public function single_ideas_shows_on_the_show_page()
    {
        $idea = Idea::factory()->create([
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $this->get(route('idea.show', $idea))
             ->assertSuccessful()
             ->assertSee($idea->title)
             ->assertSee($idea->description);
    }

    /** @test */
    
    public function ideas_pagination_works()
    {

        Idea::factory(16)->create();

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My First Title';
        $ideaOne->save();

        $ideaEleven = Idea::find(16);
        $ideaEleven->title = 'My Eleventh Title';
        $ideaEleven->save();


        $this->get('/')
             ->assertSee($ideaOne->title)
             ->assertDontSee($ideaEleven->title);

        $this->get('/?page=2')
             ->assertDontSee($ideaOne->title)
             ->assertSee($ideaEleven->title);
    }

    /** @test */
    
    public function some_idea_title_different_slugs()
    {
        
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Title',
            'description' => 'Test Description'
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Title',
            'description' => 'Test Second Description'
        ]);


        $this->get(route('idea.show', $ideaOne))
             ->assertSuccessful();
             
        $this->assertTrue(request()->path() === 'idea/my-first-title');

        $this->get(route('idea.show', $ideaTwo))
             ->assertSuccessful();

        $this->assertTrue(request()->path() === 'idea/my-second-title') ;
    }
}
