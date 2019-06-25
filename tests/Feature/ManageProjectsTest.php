<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use Facades\Tests\Setup\ProjectFactory;

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
        $this -> get($project->path().'/edit') -> assertRedirect('login');
        $this -> get($project->path()) -> assertRedirect('login');
        $this -> post('/projects', $project->toArray()) -> assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this -> withoutExceptionHandling();
        
        // authenticate the user first before checking
        $this -> signIn();

        // assume that the page route exists
        $this->get('/projects/create')->assertStatus(200);

        // save each parameter to an array for easier access
        $attributes = [
            'title' => $this -> faker -> sentence,
            'description' => $this -> faker -> sentence,
            'notes' => 'General notes here'
        ];
        
        $response = $this -> post('/projects', $attributes);
        
        // check if the user can view their project
        $project = Project::where($attributes)->first();
        $response->assertRedirect($project->path());

        $this -> get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        //given we're signed it
        $user = $this->signIn();
        //and we've been invited to a project that was not created by us
        $project = tap( ProjectFactory::create() )->invite( $user );
        // when I visit my dashboard
        $this->get( action('ProjectsController@index') )
        //I should see that project
            ->assertSee( $project->title );
    }

    /** @test */
    public function unauthorized_users_cannot_delete_projects()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
             ->delete($project->path())
             ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_update_a_project()
    {        
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
             ->patch($project->path(), $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
             ->assertRedirect($project->path());

        $this -> get($project->path().'/edit') -> assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
             ->patch($project->path(), $attributes = ['notes' => 'Changed']);

        //$this -> get($project->path().'/edit') -> assertRedirect('login');

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
             ->get( $project->path() )
             ->assertSee($project->title)
             ->assertSee($project->description);
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
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        //$this -> withoutExceptionHandling();

        $this -> signIn();

        $project = factory('App\Project') -> create();

        $this -> patch( $project->path() )->assertStatus(403);
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
