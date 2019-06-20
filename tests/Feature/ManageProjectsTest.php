<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    // we can use faker method to populate database with random values
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        //$this -> withoutExceptionHandling();

        // make a new project with a factory for checking (raw makes an array)
        $project = factory('App\Project') -> create();

        // make sure that a guest is always redirected if not signed in
        $this -> get('/projects') -> assertRedirect('login');
        $this -> get('/projects/create') -> assertRedirect('login');
        $this -> get($project->path()) -> assertRedirect('login');
        $this -> post('/projects', $project->toArray()) -> assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        // disable built-in exception handling to see the errors
        $this -> withoutExceptionHandling();

        // authenticate the user first before checking
        $this -> signIn();

        // assume that the page route exists
        $this->get('/projects/create')->assertStatus(200);

        // save each parameter to an array for easier access
        $attributes = [
            'title' => $this -> faker -> sentence,
            'description' => $this -> faker -> paragraph
        ];
        
        // test the route for creating a project
        $this -> post('/projects', $attributes) -> assertRedirect('/projects');

        // check if the database has an entry
        $this -> assertDatabaseHas('projects', $attributes);

        $this -> get('/projects') -> assertSee( $attributes['title'] );
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        //$this -> withoutExceptionHandling();

        $this -> signIn();

        $project = factory('App\Project') -> create(['owner_id' => auth()->id() ]);

        $this -> get( $project->path() )
            -> assertSee($project->title)
            -> assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        //$this -> withoutExceptionHandling();

        $this -> signIn();

        $project = factory('App\Project') -> create();

        $this -> get( $project->path() )->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        // authenticate the user first before checking
        $this -> signIn();

        // make a new project with a factory for checking (raw makes an array)
        $attributes = factory('App\Project') -> raw(['title' => '']);

        // use a helper to check if the project has a title
        $this -> post('/projects', $attributes) -> assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        // authenticate the user first before checking
        $this -> signIn();

        // make a new project with a factory for checking (raw makes an array)
        $attributes = factory('App\Project') -> raw(['description' => '']);

        // use a helper to check if the project has a description
        $this -> post('/projects', $attributes) -> assertSessionHasErrors('description');
    }
}
